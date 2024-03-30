<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\OAT\Responses\NotFoundDeleteResponse;
use App\Http\OAT\Responses\SuccessCreateResponse;
use App\Http\OAT\Responses\SuccessGetListResponse;
use App\Http\OAT\Responses\NotFoundItemResponse;
use App\Http\OAT\Responses\SuccessDeleteResponse;
use App\Http\OAT\Responses\SuccessGetViewResponse;
use App\Http\OAT\Responses\UnprocessableContentResponse;
use App\Http\Requests\API\CreateApplicationAPIRequest;
use App\Http\Requests\API\ImportApplicationAPIRequest;
use App\Http\Requests\API\GetListAppBaseAPIRequest;
use App\Http\Requests\API\UpdateApplicationAPIRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ServiceInstanceResource;
use App\Models\Application;
use App\Models\Environment;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Models\ServiceVersion;
use App\Repositories\ApplicationRepository;
use DB;
use Illuminate\Http\JsonResponse;
use Lang;
use OpenApi\Attributes as OAT;

/**
 * Class ApplicationController.
 */
class ApplicationAPIController extends AppBaseController
{
    /** @var ApplicationRepository */
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepo)
    {
        $this->authorizeResource(Application::class);
        $this->applicationRepository = $applicationRepo;
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            ...parent::resourceAbilityMap(),
            'import' => 'import'
        ];
    }

    protected function resourceMethodsWithoutModels()
    {
        return [...parent::resourceMethodsWithoutModels(), 'import'];
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/applications',
        operationId: 'getApplications',
        summary: "Get a listing of the applications.",
        description: "Get all Applications",
        tags: ["Application"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by id.",
                in: 'query',
                schema: new OAT\Schema(type: "string")
            ),
            new OAT\Parameter(
                name: "filter[name]",
                description: "Filter by name.",
                in: 'query',
                schema: new OAT\Schema(type: "string")
            ),
            new OAT\Parameter(
                name: "filter[team_id]",
                description: "Filter by team id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Applications list',
                resourceSchema: '#/components/schemas/resource-application'
            ),
        ]
    )]
    public function index(GetListAppBaseAPIRequest $request): JsonResponse
    {
        $applications = $this->applicationRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            ApplicationResource::collection($applications),
            Lang::get('application.show_confirm'),
            $applications->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/applications',
        operationId: 'storeApplication',
        summary: "Store an application.",
        description: "Store an application.",
        tags: ["Application"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-application'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created application data.',
                resourceSchema: '#/components/schemas/resource-application'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateApplicationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        return $this->sendResponse(
            new ApplicationResource($application),
            Lang::get('application.saved_confirm')
        );
    }

    /**
     * Import from docker-compose.yml file
     */
    #[OAT\Post(
        path: '/v1/applications/import',
        operationId: 'importApplication',
        summary: "Import an application.",
        description: "Import an application from a docker-compose.yml file (base64 encoded).",
        tags: ["Application"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-import-application'
            )
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Created application data.'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function import(ImportApplicationAPIRequest $request)
    {
        try {
            $input = $request->all();

            DB::transaction(function () use ($input) {
                $application = Application::firstOrCreate([
                    'name' => $input['name'],
                    'team_id' => $input['team_id'],
                ]);

                list($_contentType, $base64File) = explode(";base64,", $input['stack_file'], 2);
                $decodedFile = base64_decode($base64File);
                $stack = yaml_parse($decodedFile);
                $servicesInstances = [];
                foreach ($stack['services'] as $serviceName => $serviceProps) {
                    $service = Service::firstOrCreate([
                        'team_id' => $input['team_id'],
                        'name' => $serviceName
                    ]);
                    $version = "latest";
                    if (isset($serviceProps['image'])) {
                        $imageProps = explode(":", $serviceProps['image']);
                        $version = isset($imageProps[1]) ? $imageProps[1] : "latest";
                    }
                    $serviceVersion = ServiceVersion::firstOrCreate([
                        'service_id' => $service->id,
                        'version' => $version,
                    ]);
                    $serviceNb = 1;
                    if (isset($serviceProps['deploy']) && isset($serviceProps['deploy']['replicas'])) {
                        $serviceNb = $serviceProps['deploy']['replicas'];
                    }
                    $deps = [];
                    if (isset($serviceProps['depends_on']) && is_array($serviceProps['depends_on'])) {
                        foreach ($serviceProps['depends_on'] as $depKey => $depValue) {
                            if (isset($stack['services'][$depKey])) {
                                $deps[] = $depKey;
                                continue;
                            }
                            if (isset($stack['services'][$depValue])) {
                                $deps[] = $depValue;
                            }
                        }
                    }
                    for ($i = 1; $i <= $serviceNb; $i++) {
                        $serviceInstance = ServiceInstance::create([
                            'application_id' => $application->id,
                            'service_version_id' => $serviceVersion->id,
                            'environment_id' => $input['environment_id'],
                            'hosting_id' => $input['hosting_id'],
                            'statut' => true,
                        ]);
                        $servicesInstances[$serviceName][] = [
                            'id' => $serviceInstance->id,
                            'depends_on' => $deps
                        ];
                    }
                }

                foreach ($servicesInstances as $servicesInstance) {
                    foreach ($servicesInstance as $serviceInstanceProps) {
                        foreach ($serviceInstanceProps['depends_on'] as $depName) {
                            foreach ($servicesInstances[$depName] as $serviceDepId) {
                                ServiceInstanceDependencies::create([
                                    'instance_id' => $serviceInstanceProps['id'],
                                    'instance_dep_id' => $serviceDepId['id'],
                                    'level' => 1
                                ]);
                            }
                        }
                    }
                }

                return $this->sendResponse(
                    new ApplicationResource($application),
                    Lang::get('application.saved_confirm')
                );
            });
        } catch (\Exception $e) {
            \Log::error("Error during import application " . $e);
            return $this->sendError('Error during import application', 422);
        }
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/applications/{id}',
        operationId: 'showApplication',
        summary: "Display the specified Application.",
        description: "Get Application",
        tags: ["Application"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the application",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Application detail',
                resourceSchema: '#/components/schemas/resource-application'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Application $application): JsonResponse
    {
        if (empty($application)) {
            return $this->sendError(Lang::get('application.not_found'));
        }
        $serviceInstances = ServiceInstance::where('application_id', $application->id)
            ->with(['serviceVersion', 'serviceVersion.service', 'environment'])
            ->orderBy('environment_id')
            ->get();

        $countByEnv = Environment::withCount(['serviceInstances' => function ($query) use ($application) {
            $query->where('application_id', $application->id);
        }])
            ->join('service_instance', 'environment.id', '=', 'service_instance.environment_id')
            ->where('service_instance.application_id', $application->id)
            ->get()->keyBy('id')->toArray();

        return $this->sendResponse(
            (new ApplicationResource($application))->additional([
                'serviceInstances' => ServiceInstanceResource::collection($serviceInstances),
                'countByEnv' => $countByEnv,
            ]),
            Lang::get('application.show_confirm')
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/applications/{id}',
        operationId: 'updateApplication',
        summary: "Update an application.",
        description: "Update an application.",
        tags: ["Application"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the application",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-application'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated application data.',
                resourceSchema: '#/components/schemas/resource-application'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(Application $application, UpdateApplicationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        if (empty($application)) {
            return $this->sendError(Lang::get('application.not_found'));
        }

        $application = $this->applicationRepository->update($input, $application->id);

        return $this->sendResponse(new ApplicationResource($application), Lang::get('application.update_confirm'));
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/applications/{id}',
        operationId: 'deleteApplication',
        summary: "Delete an application.",
        description: "Delete an application and all the associated service instances.",
        tags: ["Application"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the application",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Application deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Application not found.',
            )
        ]
    )]
    public function destroy($id): JsonResponse
    {
        /** @var Application $application */
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            return $this->sendError(Lang::get('application.not_found'));
        }

        $application->delete();

        return $this->sendSuccess(Lang::get('application.delete_confirm'));
    }
}

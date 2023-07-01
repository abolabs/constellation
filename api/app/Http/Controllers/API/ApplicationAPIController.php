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
use Illuminate\Http\Request;
use Lang;
use Response;

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
     * @param  Request  $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/applications",
     *      summary="Get a listing of the Applications.",
     *      tags={"Application"},
     *      description="Get all Applications",
     *      produces={"application/json"},
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *
     *                  @SWG\Items(ref="#/definitions/Application")
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(GetListAppBaseAPIRequest $request)
    {
        $applications = $this->applicationRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(ApplicationResource::collection($applications), Lang::get('application.show_confirm'), $applications->total());
    }

    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/applications",
     *      summary="Store a newly created Application in storage",
     *      tags={"Application"},
     *      description="Store Application",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Application that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Application")
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Application"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateApplicationAPIRequest $request)
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        return $this->sendResponse(new ApplicationResource($application), Lang::get('application.saved_confirm'));
    }

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

                return $this->sendResponse(new ApplicationResource($application), Lang::get('application.saved_confirm'));
            });
        } catch (\Exception $e) {
            \Log::error("Error during import application " . $e);
            return $this->sendError('Error during import application', 422);
        }
    }

    /**
     * @param  Application $application
     * @return Response
     *
     * @SWG\Get(
     *      path="/applications/{application}",
     *      summary="Display the specified Application",
     *      tags={"Application"},
     *      description="Get Application",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Application"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Application $application)
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
     * @param  int  $id
     * @return Response
     *
     * @SWG\Put(
     *      path="/applications/{id}",
     *      summary="Update the specified Application in storage",
     *      tags={"Application"},
     *      description="Update Application",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Application that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Application")
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Application"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(Application $application, UpdateApplicationAPIRequest $request)
    {
        $input = $request->all();

        if (empty($application)) {
            return $this->sendError(Lang::get('application.not_found'));
        }

        $application = $this->applicationRepository->update($input, $application->id);

        return $this->sendResponse(new ApplicationResource($application), Lang::get('application.update_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/applications/{id}",
     *      summary="Remove the specified Application from storage",
     *      tags={"Application"},
     *      description="Delete Application",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
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

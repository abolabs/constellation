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
use App\Http\OAT\Responses\NotFoundItemResponse;
use App\Http\OAT\Responses\SuccessCreateResponse;
use App\Http\OAT\Responses\SuccessDeleteResponse;
use App\Http\OAT\Responses\SuccessGetListResponse;
use App\Http\OAT\Responses\SuccessGetViewResponse;
use App\Http\OAT\Responses\UnprocessableContentResponse;
use App\Http\Requests\API\CreateServiceAPIRequest;
use App\Http\Requests\API\UpdateServiceAPIRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class ServiceController.
 */
class ServiceAPIController extends AppBaseController
{
    /** @var ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->authorizeResource(Service::class);
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/services',
        operationId: 'getServices',
        summary: "Get a listing of the services",
        description: "Get all services.",
        tags: ["Service"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by service id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
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
                description: 'Services list',
                resourceSchema: '#/components/schemas/resource-service'
            )
        ]
    )]
    public function index(Request $request)
    {
        $services = $this->serviceRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(ServiceResource::collection($services), 'Services retrieved successfully', $services->total());
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/services',
        operationId: 'storeService',
        summary: "Store an service",
        description: "Store an service.",
        tags: ["Service"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created service data.',
                resourceSchema: '#/components/schemas/resource-service'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateServiceAPIRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        return $this->sendResponse(new ServiceResource($service), 'Service saved successfully');
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/services/{id}',
        operationId: 'showService',
        summary: "Display the specified service",
        description: "Get an service.",
        tags: ["Service"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Service detail',
                resourceSchema: '#/components/schemas/resource-service'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Service $service)
    {
        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        $service->load('versions', 'versions.instances.application');

        $serviceByApplication = [];
        foreach ($service->versions as $version) {
            $appList = [];
            foreach ($version->instances as $instance) {
                if (!isset($appList[$instance->application->id])) {
                    $appList[$instance->application->id] = (object) [
                        'id' => $instance->application->id,
                        'name' => $instance->application->name,
                        'total' => 0,
                    ];
                }
                $appList[$instance->application->id]->total++;
            }
            $serviceByApplication[$version->id] = (object) [
                'id' => $version->id,
                'version' => $version->version,
                'created_at' => $version->created_at,
                'updated_at' => $version->updated_at,
                'apps' => $appList,
            ];
        }

        return $this->sendResponse(
            (new ServiceResource($service))->additional([
                'serviceByApplication' => $serviceByApplication,
            ]),
            'Service retrieved successfully'
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/services/{id}',
        operationId: 'updateService',
        summary: "Update an service",
        description: "Update an service.",
        tags: ["Service"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated service data.',
                resourceSchema: '#/components/schemas/resource-service'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(Service $service, UpdateServiceAPIRequest $request)
    {
        $input = $request->all();

        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        $service = $this->serviceRepository->update($input, $service->id);

        return $this->sendResponse(new ServiceResource($service), 'Service updated successfully');
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/services/{id}',
        operationId: 'deleteService',
        summary: "Delete an service",
        description: "Remove the specified Service from storage.",
        tags: ["Service"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Service deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Service not found.',
            ),
        ]
    )]
    public function destroy(Service $service)
    {
        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        $service->delete();

        return $this->sendSuccess('Service deleted successfully');
    }
}

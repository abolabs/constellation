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
use App\Http\Requests\API\CreateServiceInstanceAPIRequest;
use App\Http\Requests\API\UpdateServiceInstanceAPIRequest;
use App\Http\Resources\ServiceInstanceResource;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class ServiceInstanceController.
 */
class ServiceInstanceAPIController extends AppBaseController
{
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;

    public function __construct(ServiceInstanceRepository $serviceInstanceRepo)
    {
        $this->authorizeResource(ServiceInstance::class);
        $this->serviceInstanceRepository = $serviceInstanceRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/service_instances',
        operationId: 'getServiceInstances',
        summary: "Get a listing of the service instances",
        description: "Get all service instances.",
        tags: ["Service instance"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by service instance id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[environment_id]",
                description: "Filter by service environment id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[hosting_name]",
                description: "Filter by service hosting name.",
                in: 'query',
                schema: new OAT\Schema(type: "string")
            ),
            new OAT\Parameter(
                name: "filter[hosting_id]",
                description: "Filter by service hosting id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[application_name]",
                description: "Filter by service application name.",
                in: 'query',
                schema: new OAT\Schema(type: "string")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Service instances list',
                resourceSchema: '#/components/schemas/resource-service-instance'
            )
        ]
    )]
    public function index(Request $request)
    {
        $serviceInstances = $this->serviceInstanceRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(ServiceInstanceResource::collection($serviceInstances), 'Service Instances retrieved successfully', $serviceInstances->total());
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/service_instances',
        operationId: 'storeServiceInstance',
        summary: "Store an service instance",
        description: "Store an service instance.",
        tags: ["Service instance"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-instance'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created serviceinstance data.',
                resourceSchema: '#/components/schemas/resource-service-instance'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateServiceInstanceAPIRequest $request)
    {
        $input = $request->all();

        $serviceInstance = $this->serviceInstanceRepository->create($input);

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'Service Instance saved successfully');
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/service_instances/{id}',
        operationId: 'showServiceInstance',
        summary: "Display the specified service instance",
        description: "Get an service instance.",
        tags: ["Service instance"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'ServiceInstance detail',
                resourceSchema: '#/components/schemas/resource-service-instance'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $instanceDependencies = ServiceInstanceDependencies::where('instance_id', $serviceInstance->id)
            ->with([
                'serviceInstanceDep',
                'serviceInstanceDep.hosting',
                'serviceInstanceDep.application',
                'serviceInstanceDep.serviceVersion',
                'serviceInstanceDep.serviceVersion.service',
            ])->get();

        $instanceDependenciesSource = ServiceInstanceDependencies::where('instance_dep_id', $serviceInstance->id)
            ->with([
                'serviceInstance',
                'serviceInstance.hosting',
                'serviceInstance.application',
                'serviceInstance.serviceVersion',
                'serviceInstance.serviceVersion.service',
            ])->get();

        return $this->sendResponse(
            (new ServiceInstanceResource($serviceInstance))->additional([
                'instanceDependencies' => $instanceDependencies,
                'instanceDependenciesSource' => $instanceDependenciesSource,
            ]),
            'Service Instance retrieved successfully'
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/service_instances/{id}',
        operationId: 'updateServiceInstance',
        summary: "Update an service instance",
        description: "Update an service instance.",
        tags: ["Service instance"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-instance'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated serviceinstance data.',
                resourceSchema: '#/components/schemas/resource-service-instance'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(ServiceInstance $serviceInstance, UpdateServiceInstanceAPIRequest $request)
    {
        $input = $request->all();

        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance = $this->serviceInstanceRepository->update($input, $serviceInstance->id);

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'ServiceInstance updated successfully');
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/service_instances/{id}',
        operationId: 'deleteServiceInstance',
        summary: "Delete an service instance",
        description: "Remove the specified service instance from storage.",
        tags: ["Service instance"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Service instance deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Service instance not found.',
            ),
        ]
    )]
    public function destroy(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance->delete();

        return $this->sendSuccess('Service Instance deleted successfully');
    }
}

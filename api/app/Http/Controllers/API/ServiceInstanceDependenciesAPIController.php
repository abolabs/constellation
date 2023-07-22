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
use App\Http\Requests\API\CreateServiceInstanceDependenciesAPIRequest;
use App\Http\Requests\API\UpdateServiceInstanceDependenciesAPIRequest;
use App\Http\Resources\ServiceInstanceDependenciesResource;
use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceDependenciesRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class ServiceInstanceDependenciesController.
 */
class ServiceInstanceDependenciesAPIController extends AppBaseController
{
    /** @var ServiceInstanceDependenciesRepository */
    private $serviceInstanceDependenciesRepository;

    public function __construct(ServiceInstanceDependenciesRepository $serviceInstanceDependenciesRepo)
    {
        $this->authorizeResource(ServiceInstanceDependencies::class);
        $this->serviceInstanceDependenciesRepository = $serviceInstanceDependenciesRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/service_instance_dependencies',
        operationId: 'getServiceInstanceDependenciess',
        summary: "Get a listing of the service instance dependencies",
        description: "Get all service instance dependenciess.",
        tags: ["Service instance dependencies"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by service instance dependency id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Service instance dependenciess list',
                resourceSchema: '#/components/schemas/resource-service-instance-dependencies'
            )
        ]
    )]
    public function index(Request $request)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            result: ServiceInstanceDependenciesResource::collection($serviceInstanceDependencies),
            message: 'Service instance dependencies retrieved successfully',
            total: $serviceInstanceDependencies->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/service_instance_dependencies',
        operationId: 'storeServiceInstanceDependency',
        summary: "Store an service instance dependency",
        description: "Store an service instance dependency.",
        tags: ["Service instance dependencies"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-instance-dependency'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created serviceinstancedependencies data.',
                resourceSchema: '#/components/schemas/resource-service-instance-dependencies'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateServiceInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->create($input);

        return $this->sendResponse(
            result: new ServiceInstanceDependenciesResource($serviceInstanceDependencies),
            message: 'Service instance dependency successfully saved'
        );
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/service_instance_dependencies/{id}',
        operationId: 'showServiceInstanceDependency',
        summary: "Display the specified service instance dependency",
        description: "Get an service instance dependency.",
        tags: ["Service instance dependencies"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance dependency",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Service instance dependency detail',
                resourceSchema: '#/components/schemas/resource-service-instance-dependencies'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(int $id)
    {
        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service instance dependency not found');
        }

        $serviceInstanceDependencies->load([
            'serviceInstance',
            'serviceInstance.application',
            'serviceInstanceDep',
            'serviceInstanceDep.application'
        ]);

        return $this->sendResponse(
            result: new ServiceInstanceDependenciesResource($serviceInstanceDependencies),
            message: 'Service instance dependency retrieved successfully'
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/service_instance_dependencies/{id}',
        operationId: 'updateServiceInstanceDependency',
        summary: "Update a service instance dependency",
        description: "Update a service instance dependency.",
        tags: ["Service instance dependencies"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance dependency",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-instance-dependency'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated serviceinstancedependencies data.',
                resourceSchema: '#/components/schemas/resource-service-instance-dependencies'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(int $id, UpdateServiceInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service instance dependency not found');
        }

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->update($input, $serviceInstanceDependencies->id);

        return $this->sendResponse(
            result: new ServiceInstanceDependenciesResource($serviceInstanceDependencies),
            message: 'Service instance dependency updated successfully'
        );
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/service_instance_dependencies/{id}',
        operationId: 'deleteServiceInstanceDependency',
        summary: "Delete a service instance dependency",
        description: "Remove the specified service instance dependency from storage.",
        tags: ["Service instance dependencies"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service instance dependency",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(description: 'Service instance dependency deleted.'),
            new NotFoundDeleteResponse(description: 'Service instance dependency not found.'),
        ]
    )]
    public function destroy(int $id)
    {

        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service instance dependency not found');
        }

        $serviceInstanceDependencies->delete();

        return $this->sendSuccess('Service instance dependency successfully deleted');
    }
}

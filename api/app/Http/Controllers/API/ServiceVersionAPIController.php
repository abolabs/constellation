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
use App\Http\Requests\API\CreateServiceVersionAPIRequest;
use App\Http\Requests\API\UpdateServiceVersionAPIRequest;
use App\Http\Resources\ServiceVersionResource;
use App\Models\ServiceVersion;
use App\Repositories\ServiceVersionRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class ServiceVersionController.
 */
class ServiceVersionAPIController extends AppBaseController
{
    /** @var ServiceVersionRepository */
    private $serviceVersionRepository;

    public function __construct(ServiceVersionRepository $serviceVersionRepo)
    {
        $this->authorizeResource(ServiceVersion::class);
        $this->serviceVersionRepository = $serviceVersionRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/service_versions',
        operationId: 'getServiceVersions',
        summary: "Get a listing of the service versions",
        description: "Get all service versions.",
        tags: ["Service version"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by service version id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[service_id]",
                description: "Filter by service id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Service versions list',
                resourceSchema: '#/components/schemas/resource-service-version'
            )
        ]
    )]
    public function index(Request $request)
    {
        $serviceVersions = $this->serviceVersionRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );
        $serviceVersions->load('service');

        return $this->sendResponse(
            result: ServiceVersionResource::collection($serviceVersions),
            message: 'Service versions successfully retrieved',
            total: $serviceVersions->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/service_versions',
        operationId: 'storeServiceVersion',
        summary: "Store a service version",
        description: "Store a service version.",
        tags: ["Service version"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-version'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created service version data.',
                resourceSchema: '#/components/schemas/resource-service-version'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateServiceVersionAPIRequest $request)
    {
        $input = $request->all();

        $serviceVersion = $this->serviceVersionRepository->create($input);

        return $this->sendResponse(
            result: new ServiceVersionResource($serviceVersion),
            message: 'Service version successfully saved'
        );
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/service_versions/{id}',
        operationId: 'showServiceVersion',
        summary: "Display the specified service version",
        description: "Get a service version.",
        tags: ["Service version"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service version",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Service version detail',
                resourceSchema: '#/components/schemas/resource-service-version'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            return $this->sendError('Service version not found');
        }

        return $this->sendResponse(
            result: new ServiceVersionResource($serviceVersion),
            message: 'Service version successfully retrieved'
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/service_versions/{id}',
        operationId: 'updateServiceVersion',
        summary: "Update an service version",
        description: "Update an service version.",
        tags: ["Service version"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service version",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-service-version'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated service version data.',
                resourceSchema: '#/components/schemas/resource-service-version'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(ServiceVersion $serviceVersion, UpdateServiceVersionAPIRequest $request)
    {
        $input = $request->all();

        if (empty($serviceVersion)) {
            return $this->sendError('Service version not found');
        }

        $serviceVersion = $this->serviceVersionRepository->update($input, $serviceVersion->id);

        return $this->sendResponse(
            result: new ServiceVersionResource($serviceVersion),
            message: 'Service version successfully updated'
        );
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/service_versions/{id}',
        operationId: 'deleteServiceVersion',
        summary: "Delete an service version",
        description: "Remove the specified service version from storage.",
        tags: ["Service version"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the service version",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Service version deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Service version not found.',
            ),
        ]
    )]
    public function destroy(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            return $this->sendError('Service version not found');
        }

        $serviceVersion->delete();

        return $this->sendSuccess('Service version successfully deleted');
    }
}

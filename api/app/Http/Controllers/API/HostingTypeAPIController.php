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
use App\Http\Requests\API\CreateHostingTypeAPIRequest;
use App\Http\Requests\API\UpdateHostingTypeAPIRequest;
use App\Http\Resources\HostingTypeResource;
use App\Models\HostingType;
use App\Repositories\HostingTypeRepository;
use Illuminate\Http\Request;
use Lang;
use OpenApi\Attributes as OAT;

/**
 * Class HostingTypeController.
 */
class HostingTypeAPIController extends AppBaseController
{
    /** @var HostingTypeRepository */
    private $hostingTypeRepository;

    public function __construct(HostingTypeRepository $hostingTypeRepo)
    {
        $this->authorizeResource(HostingType::class);
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/hosting_types',
        operationId: 'getHostingTypes',
        summary: "Get a listing of the hosting types",
        description: "Get all hosting types.",
        tags: ["Hosting type"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by hosting type id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Hosting types list',
                resourceSchema: '#/components/schemas/resource-hosting-type'
            ),
        ]
    )]
    public function index(Request $request)
    {
        $hostingTypes = $this->hostingTypeRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(HostingTypeResource::collection($hostingTypes), Lang::get('hosting_type.index_confirm'), $hostingTypes->total());
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/hosting_types',
        operationId: 'storeHostingType',
        summary: "Store an hosting type",
        description: "Store an hosting type.",
        tags: ["Hosting type"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-hosting-type'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created hosting type data.',
                resourceSchema: '#/components/schemas/resource-hosting-type'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateHostingTypeAPIRequest $request)
    {
        $input = $request->all();

        $hostingType = $this->hostingTypeRepository->create($input);

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.store_confirm'));
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/hosting_types/{id}',
        operationId: 'showHostingType',
        summary: "Display the specified hosting type",
        description: "Get an hosting type.",
        tags: ["Hosting type"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting type",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Hosting type detail',
                resourceSchema: '#/components/schemas/resource-hosting-type'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(HostingType $hostingType)
    {
        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.show_confirm'));
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/hosting_types/{id}',
        operationId: 'updateHostingType',
        summary: "Update an hostingType",
        description: "Update an hosting type.",
        tags: ["Hosting type"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting type",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-hosting-type'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated hosting type data.',
                resourceSchema: '#/components/schemas/resource-hosting-type'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(HostingType $hostingType, UpdateHostingTypeAPIRequest $request)
    {
        $input = $request->all();

        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        $hostingType = $this->hostingTypeRepository->update($input, $hostingType->id);

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.update_confirm'));
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/hosting_types/{id}',
        operationId: 'deleteHostingType',
        summary: "Delete an hosting type",
        description: "Remove the specified hosting type from storage.",
        tags: ["Hosting type"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting type",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Hosting type deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Hosting type not found.',
            ),
        ]
    )]
    public function destroy(HostingType $hostingType)
    {
        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        $hostingType->delete();

        return $this->sendSuccess(Lang::get('hosting_type.destroy_confirm'));
    }
}

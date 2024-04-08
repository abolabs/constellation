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
use App\Http\Requests\API\CreateHostingAPIRequest;
use App\Http\Requests\API\UpdateHostingAPIRequest;
use App\Http\Resources\HostingResource;
use App\Http\Resources\ServiceInstanceResource;
use App\Models\Hosting;
use App\Models\ServiceInstance;
use App\Repositories\HostingRepository;
use Illuminate\Http\Request;
use Lang;
use Symfony\Component\HttpFoundation\Response as HttpCode;
use OpenApi\Attributes as OAT;

/**
 * Class HostingController.
 */
class HostingAPIController extends AppBaseController
{
    /** @var HostingRepository */
    private $hostingRepository;

    public function __construct(HostingRepository $hostingRepo)
    {
        $this->authorizeResource(Hosting::class);
        $this->hostingRepository = $hostingRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/hostings',
        operationId: 'getHostings',
        summary: "Get a listing of the hostings",
        description: "Get all hostings.",
        tags: ["Hosting"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by hosting id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[hosting_type_id]",
                description: "Filter by hosting type id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Hostings list',
                resourceSchema: '#/components/schemas/resource-hosting'
            ),
        ]
    )]
    public function index(Request $request)
    {
        $hostings = $this->hostingRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            HostingResource::collection($hostings),
            Lang::get('hosting.index_confirm'),
            $hostings->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/hostings',
        operationId: 'storeHosting',
        summary: "Store an hosting",
        description: "Store an hosting.",
        tags: ["Hosting"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-hosting'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created hosting data.',
                resourceSchema: '#/components/schemas/resource-hosting'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateHostingAPIRequest $request)
    {
        $input = $request->all();

        $hosting = $this->hostingRepository->create($input);

        return $this->sendResponse(new HostingResource($hosting), Lang::get('hosting.store_confirm'));
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/hostings/{id}',
        operationId: 'showHosting',
        summary: "Display the specified hosting",
        description: "Get an hosting.",
        tags: ["Hosting"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Hosting detail',
                resourceSchema: '#/components/schemas/resource-hosting'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Hosting $hosting)
    {
        if (empty($hosting)) {
            return $this->sendError('Hosting not found');
        }

        $serviceInstances = ServiceInstance::where('hosting_id', $hosting->id)
            ->with(['serviceVersion', 'serviceVersion.service', 'environment'])
            ->get();

        return $this->sendResponse(
            (new HostingResource($hosting))->additional([
                'serviceInstances' => ServiceInstanceResource::collection($serviceInstances),
            ]),
            Lang::get('hosting.show_confirm')
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/hostings/{id}',
        operationId: 'updateHosting',
        summary: "Update an hosting",
        description: "Update an hosting.",
        tags: ["Hosting"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-hosting'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated hosting data.',
                resourceSchema: '#/components/schemas/resource-hosting'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(Hosting $hosting, UpdateHostingAPIRequest $request)
    {
        $input = $request->all();

        if (empty($hosting)) {
            return $this->sendError(Lang::get('hosting.not_found'));
        }

        $hosting = $this->hostingRepository->update($input, $hosting->id);

        return $this->sendResponse(new HostingResource($hosting), Lang::get('hosting.update_confirm'));
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/hostings/{id}',
        operationId: 'deleteHosting',
        summary: "Delete an hosting",
        description: "Remove the specified Hosting from storage.",
        tags: ["Hosting"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the hosting",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Hosting deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Hosting not found.',
            ),
        ]
    )]
    public function destroy(Hosting $hosting)
    {
        if (empty($hosting)) {
            return $this->sendError(Lang::get('hosting.not_found'));
        }
        $hosting->load('serviceInstances');
        if (count($hosting->serviceInstances) > 0) {
            return $this->sendError(
                'Hosting is currently used, please delete associated instances before.',
                HttpCode::HTTP_PRECONDITION_FAILED
            );
        }

        $hosting->delete();

        return $this->sendSuccess(Lang::get('hosting.destroy_confirm'));
    }
}

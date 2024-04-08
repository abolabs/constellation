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
use App\Http\Requests\API\CreateEnvironmentAPIRequest;
use App\Http\Requests\API\UpdateEnvironmentAPIRequest;
use App\Http\Resources\EnvironmentResource;
use App\Models\Environment;
use App\Repositories\EnvironmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class EnvironmentController.
 */
class EnvironmentAPIController extends AppBaseController
{
    /** @var EnvironmentRepository */
    private $environmentRepository;

    public function __construct(EnvironmentRepository $environmentRepo)
    {
        $this->authorizeResource(Environment::class);
        $this->environmentRepository = $environmentRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/environments',
        operationId: 'getEnvironments',
        summary: "Get a listing of the environments",
        description: "Get all environments.",
        tags: ["Environment"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by environment id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Environments list',
                resourceSchema: '#/components/schemas/resource-environment'
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $environments = $this->environmentRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            EnvironmentResource::collection($environments),
            \Lang::get('environment.show_confirm'),
            $environments->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/environments',
        operationId: 'storeEnvironment',
        summary: "Store an environment",
        description: "Store an environment.",
        tags: ["Environment"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-environment'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created environment data.',
                resourceSchema: '#/components/schemas/resource-environment'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateEnvironmentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $environment = $this->environmentRepository->create($input);

        return $this->sendResponse(new EnvironmentResource($environment), \Lang::get('environment.saved_confirm'));
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/environments/{id}',
        operationId: 'showEnvironment',
        summary: "Display the specified environment",
        description: "Get an environment.",
        tags: ["Environment"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the environment",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Environment detail',
                resourceSchema: '#/components/schemas/resource-environment'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Environment $environment): JsonResponse
    {
        if (empty($environment)) {
            return $this->sendError(\Lang::get('environment.not_found'));
        }

        return $this->sendResponse(
            new EnvironmentResource($environment),
            \Lang::get('environment.show_confirm')
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/environments/{id}',
        operationId: 'updateEnvironment',
        summary: "Update an environment",
        description: "Update an environment.",
        tags: ["Environment"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the environment",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-environment'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated environment data.',
                resourceSchema: '#/components/schemas/resource-environment'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(Environment $environment, UpdateEnvironmentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        if (empty($environment)) {
            return $this->sendError(\Lang::get('environment.not_found'));
        }

        $environment = $this->environmentRepository->update($input, $environment->id);

        return $this->sendResponse(new EnvironmentResource($environment), \Lang::get('environment.update_confirm'));
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/environments/{id}',
        operationId: 'deleteEnvironment',
        summary: "Delete an environment",
        description: "Remove the specified Environment from storage.",
        tags: ["Environment"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the environment",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Environment deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Environment not found.',
            ),
        ]
    )]
    public function destroy(Environment $environment): JsonResponse
    {
        if (empty($environment)) {
            return $this->sendError(\Lang::get('environment.not_found'));
        }

        $environment->delete();

        return $this->sendSuccess(\Lang::get('environment.delete_confirm'));
    }
}

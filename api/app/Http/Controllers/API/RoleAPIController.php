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
use App\Http\Requests\API\CreateRoleAPIRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class RoleController.
 */
class RoleAPIController extends AppBaseController
{
    /** @var RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->middleware(['role:Admin']);
        $this->roleRepository = $roleRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/roles',
        operationId: 'getRoles',
        summary: "Get a listing of the roles",
        description: "Get all roles.",
        tags: ["Role"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by role id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[name]",
                description: "Filter by role name.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Roles list',
                resourceSchema: '#/components/schemas/resource-role'
            )
        ]
    )]
    public function index(Request $request)
    {
        $roles = $this->roleRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(RoleResource::collection($roles), 'Roles retrieved successfully', $roles->total());
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/roles',
        operationId: 'storeRole',
        summary: "Store an role",
        description: "Store an role.",
        tags: ["Role"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-role'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created role data.',
                resourceSchema: '#/components/schemas/resource-role'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateRoleAPIRequest $request)
    {
        $role = $this->roleRepository->create([
            'name' => $request->input('name'),
            'guard_name' => 'api',
        ]);

        $role->syncPermissions($request->input('permissions'));

        return $this->sendResponse(new RoleResource($role), 'Role saved successfully');
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/roles/{id}',
        operationId: 'showRole',
        summary: "Display the specified role",
        description: "Get an role.",
        tags: ["Role"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the role",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Role detail',
                resourceSchema: '#/components/schemas/resource-role'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show($id)
    {
        /** @var Role $Role */
        $role = $this->roleRepository->find($id);
        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse(new RoleResource($role), 'Role retrieved successfully');
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/roles/{id}',
        operationId: 'updateRole',
        summary: "Update an role",
        description: "Update an role.",
        tags: ["Role"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the role",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-role'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated role data.',
                resourceSchema: '#/components/schemas/resource-role'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Role $Role */
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role = $this->roleRepository->update($input, $id);
        $role->syncPermissions($request->input('permissions'));

        return $this->sendResponse(new RoleResource($role), 'Role updated successfully');
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/roles/{id}',
        operationId: 'deleteRole',
        summary: "Delete an role",
        description: "Remove the specified role from storage.",
        tags: ["Role"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the role",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(description: 'Role deleted.'),
            new NotFoundDeleteResponse(description: 'Role not found.'),
        ]
    )]
    public function destroy($id)
    {
        /** @var Role $Role */
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role->delete();

        return $this->sendSuccess('Role deleted successfully');
    }
}

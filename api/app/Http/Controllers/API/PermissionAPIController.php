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
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpCode;
use OpenApi\Attributes as OAT;

class PermissionAPIController extends AppBaseController
{
    /** @var PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware(['role:Admin']);
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/permissions',
        operationId: 'getPermissions',
        summary: "Get a listing of the permissions",
        description: "Get all permissions.",
        tags: ["Permission"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by permission id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "filter[name]",
                description: "Filter by permission name.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Permissions list',
                content: new OAT\JsonContent(
                    type: 'object',
                    properties: [
                        new OAT\Property(property: 'success', type: 'boolean'),
                        new OAT\Property(
                            property: 'data',
                            type: 'array',
                            items: new OAT\Items(
                                ref: '#/components/schemas/resource-permission'
                            )
                        ),
                        new OAT\Property(property: 'message', type: 'string'),
                        new OAT\Property(property: 'total', type: 'int'),
                    ]
                ),
            ),
        ]
    )]
    public function index(Request $request)
    {
        $search = $request->except(['perPage', 'page', 'sort']);
        $formattedSearch = $search;
        // dirty adapter to manage pivot from role
        if (isset($search['filter']) && isset($search['filter']['id'])) {
            foreach ($search['filter'] as $filterValue) {
                if (is_array($filterValue) && isset($filterValue[0]) && isset($filterValue[0]['id']) && is_array($filterValue)) {
                    $formattedSearch['filter']['id'] = [];
                    foreach ($filterValue as $toFormatValues) {
                        if (is_array($toFormatValues) && isset($toFormatValues['id'])) {
                            $formattedSearch['filter']['id'][] = $toFormatValues['id'];
                        } else {
                            $formattedSearch['filter']['id'][] = $toFormatValues;
                        }
                    }
                }
            }
        }
        $permissions = $this->permissionRepository->apiAll(
            $formattedSearch,
            $request->perPage ?? BaseRepository::DEFAULT_LIMIT,
            $request->page,
            $request->sort ?? 'name'
        );

        return $this->sendResponse(PermissionResource::collection($permissions), 'Permissions retrieved successfully', $permissions->total());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        return $this->sendResponse(new PermissionResource($permission), 'Permission retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }
}

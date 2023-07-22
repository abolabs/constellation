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
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\ProfileUpdateRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OAT;

/**
 * Class UserController.
 */
class UserAPIController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->authorizeResource(User::class);
        $this->userRepository = $userRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/users',
        operationId: 'getUsers',
        summary: "Get a listing of the users",
        description: "Get all users.",
        tags: ["User"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by user id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Users list',
                resourceSchema: '#/components/schemas/resource-user'
            )
        ]
    )]
    public function index(Request $request)
    {
        $users = $this->userRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            result: UserResource::collection($users),
            message: 'Users successfully retrieved',
            total: $users->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/users',
        operationId: 'storeUser',
        summary: "Store an user",
        description: "Store an user.",
        tags: ["User"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-user'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created user data.',
                resourceSchema: '#/components/schemas/resource-user'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);
        $user->assignRole($request->input('roles'));

        return $this->sendResponse(
            result: new UserResource($user),
            message: 'User successfully saved'
        );
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/users/{id}',
        operationId: 'showUser',
        summary: "Display the specified user",
        description: "Get an user.",
        tags: ["User"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the user",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'User detail',
                resourceSchema: '#/components/schemas/resource-user'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(User $user)
    {
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse(
            result: new UserResource($user),
            message: 'User successfully retrieved'
        );
    }


    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/users/{id}',
        operationId: 'updateUser',
        summary: "Update an user",
        description: "Update an user.",
        tags: ["User"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the user",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-user'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated user data.',
                resourceSchema: '#/components/schemas/resource-user'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(User $user, UpdateUserAPIRequest $request)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));

        return $this->sendResponse(
            result: new UserResource($user),
            message: 'User successfully updated'
        );
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/users/{id}',
        operationId: 'deleteUser',
        summary: "Delete an user",
        description: "Remove the specified user from storage.",
        tags: ["User"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the user",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(description: 'User deleted.'),
            new NotFoundDeleteResponse(description: 'User not found.'),
        ]
    )]
    public function destroy(User $user)
    {
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User successfully deleted');
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $input = $request->all();
        $user = \Auth::user();
        $user->update($input);

        // Revoke and delete the current token
        $user->token()->revoke();
        $user->token()->delete();

        // Create a new token
        $accessToken = $user->createToken('', ['*']);

        return $this->sendResponse(
            (new UserResource($user))->additional([
                'jwt' => [
                    'access_token' => $accessToken->accessToken,
                ],
            ]),
            'Account updated successfully'
        );
    }

    public function getPermissions()
    {
        try {
            $user = \Auth::user();

            if (empty($user)) {
                return $this->sendError('User not found');
            }

            $permissions = $user->getAllPermissions()->map(fn ($item) => $item['name']);

            return $this->sendResponse($permissions, 'Permissions retrieves successfully');
        } catch (\Exception $e) {
            \Log::error("Cannot retrive current user's permissions. " . $e);

            return $this->sendError('Error during retrieving permissions');
        }
    }
}

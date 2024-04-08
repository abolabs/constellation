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
use App\Http\Requests\API\CreateTeamAPIRequest;
use App\Http\Requests\API\UpdateTeamAPIRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

/**
 * Class TeamController.
 */
class TeamAPIController extends AppBaseController
{
    /** @var TeamRepository */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->authorizeResource(Team::class);
        $this->teamRepository = $teamRepo;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/teams',
        operationId: 'getTeams',
        summary: "Get a listing of the teams",
        description: "Get all teams.",
        tags: ["Team"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[id]",
                description: "Filter by team id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Teams list',
                resourceSchema: '#/components/schemas/resource-team'
            )
        ]
    )]
    public function index(Request $request)
    {
        $teams = $this->teamRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(
            result: TeamResource::collection($teams),
            message: 'Teams retrieved successfully',
            total: $teams->total()
        );
    }

    /**
     * Store
     */
    #[OAT\Post(
        path: '/v1/teams',
        operationId: 'storeTeam',
        summary: "Store an team",
        description: "Store an team.",
        tags: ["Team"],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-team'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Created team data.',
                resourceSchema: '#/components/schemas/resource-team'
            ),
            new UnprocessableContentResponse()
        ]
    )]
    public function store(CreateTeamAPIRequest $request)
    {
        $input = $request->all();

        $team = $this->teamRepository->create($input);

        return $this->sendResponse(
            result: new TeamResource($team),
            message: 'Team successfully saved'
        );
    }

    /**
     * View
     */
    #[OAT\Get(
        path: '/v1/teams/{id}',
        operationId: 'showTeam',
        summary: "Display the specified team",
        description: "Get an team.",
        tags: ["Team"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the team",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Team detail',
                resourceSchema: '#/components/schemas/resource-team'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Team $team)
    {
        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        return $this->sendResponse(
            result: new TeamResource($team),
            message: 'Team successfully retrieved'
        );
    }

    /**
     * Update
     */
    #[OAT\Put(
        path: '/v1/teams/{id}',
        operationId: 'updateTeam',
        summary: "Update a team",
        description: "Update a team.",
        tags: ["Team"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the team",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                ref: '#/components/schemas/request-create-team'
            )
        ),
        responses: [
            new SuccessCreateResponse(
                description: 'Updated team data.',
                resourceSchema: '#/components/schemas/resource-team'
            ),
            new UnprocessableContentResponse(),
            new NotFoundItemResponse()
        ]
    )]
    public function update(Team $team, UpdateTeamAPIRequest $request)
    {
        $input = $request->all();

        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        $team = $this->teamRepository->update($input, $team->id);

        return $this->sendResponse(
            result: new TeamResource($team),
            message: 'Team successfully updated'
        );
    }

    /**
     * Delete
     */
    #[OAT\Delete(
        path: '/v1/teams/{id}',
        operationId: 'deleteTeam',
        summary: "Delete an team",
        description: "Remove the specified Team from storage.",
        tags: ["Team"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the team",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessDeleteResponse(
                description: 'Team deleted.'
            ),
            new NotFoundDeleteResponse(
                description: 'Team not found.',
            ),
        ]
    )]
    public function destroy(Team $team)
    {
        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        $team->delete();

        return $this->sendSuccess('Team successfully deleted');
    }
}

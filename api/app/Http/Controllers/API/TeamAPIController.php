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
use App\Http\Requests\API\CreateTeamAPIRequest;
use App\Http\Requests\API\UpdateTeamAPIRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;
use Response;

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
     * @return Response
     *
     * @SWG\Get(
     *      path="/teams",
     *      summary="Get a listing of the Teams.",
     *      tags={"Team"},
     *      description="Get all Teams",
     *      produces={"application/json"},
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *
     *                  @SWG\Items(ref="#/definitions/Team")
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $teams = $this->teamRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(TeamResource::collection($teams), 'Teams retrieved successfully', $teams->total());
    }

    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/teams",
     *      summary="Store a newly created Team in storage",
     *      tags={"Team"},
     *      description="Store Team",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Team that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Team")
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Team"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTeamAPIRequest $request)
    {
        $input = $request->all();

        $team = $this->teamRepository->create($input);

        return $this->sendResponse(new TeamResource($team), 'Team saved successfully');
    }

    /**
     * @param  Team $team
     * @return Response
     *
     * @SWG\Get(
     *      path="/teams/{id}",
     *      summary="Display the specified Team",
     *      tags={"Team"},
     *      description="Get Team",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Team",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Team"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Team $team)
    {
        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        return $this->sendResponse(new TeamResource($team), 'Team retrieved successfully');
    }

    /**
     * @param  Team $team
     * @return Response
     *
     * @SWG\Put(
     *      path="/teams/{id}",
     *      summary="Update the specified Team in storage",
     *      tags={"Team"},
     *      description="Update Team",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Team",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Team that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Team")
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Team"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(Team $team, UpdateTeamAPIRequest $request)
    {
        $input = $request->all();

        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        $team = $this->teamRepository->update($input, $team->id);

        return $this->sendResponse(new TeamResource($team), 'Team updated successfully');
    }

    /**
     * @param  Team $team
     * @return Response
     *
     * @SWG\Delete(
     *      path="/teams/{id}",
     *      summary="Remove the specified Team from storage",
     *      tags={"Team"},
     *      description="Delete Team",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Team",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy(Team $team)
    {
        if (empty($team)) {
            return $this->sendError('Team not found');
        }

        $team->delete();

        return $this->sendSuccess('Team deleted successfully');
    }
}

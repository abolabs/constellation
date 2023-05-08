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
use App\Http\Requests\API\CreateEnvironnementAPIRequest;
use App\Http\Requests\API\UpdateEnvironnementAPIRequest;
use App\Http\Resources\EnvironnementResource;
use App\Models\Environnement;
use App\Repositories\EnvironnementRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class EnvironnementController.
 */
class EnvironnementAPIController extends AppBaseController
{
    /** @var EnvironnementRepository */
    private $environnementRepository;

    public function __construct(EnvironnementRepository $environnementRepo)
    {
        $this->environnementRepository = $environnementRepo;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/environnements",
     *      summary="Get a listing of the Environnements.",
     *      tags={"Environnement"},
     *      description="Get all Environnements",
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
     *                  @SWG\Items(ref="#/definitions/Environnement")
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
        $environnements = $this->environnementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $environnements = $this->environnementRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(EnvironnementResource::collection($environnements), \Lang::get('environnement.show_confirm'), $environnements->total());
    }

    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/environnements",
     *      summary="Store a newly created Environnement in storage",
     *      tags={"Environnement"},
     *      description="Store Environnement",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Environnement that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Environnement")
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
     *                  ref="#/definitions/Environnement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEnvironnementAPIRequest $request)
    {
        $input = $request->all();

        $environnement = $this->environnementRepository->create($input);

        return $this->sendResponse(new EnvironnementResource($environnement), \Lang::get('environnement.saved_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/environnements/{id}",
     *      summary="Display the specified Environnement",
     *      tags={"Environnement"},
     *      description="Get Environnement",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environnement",
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
     *                  ref="#/definitions/Environnement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError(\Lang::get('environnement.not_found'));
        }

        return $this->sendResponse(new EnvironnementResource($environnement), \Lang::get('environnement.show_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Put(
     *      path="/environnements/{id}",
     *      summary="Update the specified Environnement in storage",
     *      tags={"Environnement"},
     *      description="Update Environnement",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environnement",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Environnement that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Environnement")
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
     *                  ref="#/definitions/Environnement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEnvironnementAPIRequest $request)
    {
        $input = $request->all();

        /** @var Environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError(\Lang::get('environnement.not_found'));
        }

        $environnement = $this->environnementRepository->update($input, $id);

        return $this->sendResponse(new EnvironnementResource($environnement), \Lang::get('environnement.update_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/environnements/{id}",
     *      summary="Remove the specified Environnement from storage",
     *      tags={"Environnement"},
     *      description="Delete Environnement",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environnement",
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
    public function destroy($id)
    {
        /** @var Environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError(\Lang::get('environnement.not_found'));
        }

        $environnement->delete();

        return $this->sendSuccess(\Lang::get('environnement.delete_confirm'));
    }
}

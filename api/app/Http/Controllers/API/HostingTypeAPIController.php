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
use App\Http\Requests\API\CreateHostingTypeAPIRequest;
use App\Http\Requests\API\UpdateHostingTypeAPIRequest;
use App\Http\Resources\HostingTypeResource;
use App\Models\HostingType;
use App\Repositories\HostingTypeRepository;
use Illuminate\Http\Request;
use Lang;
use Response;

/**
 * Class HostingTypeController.
 */
class HostingTypeAPIController extends AppBaseController
{
    /** @var HostingTypeRepository */
    private $hostingTypeRepository;

    public function __construct(HostingTypeRepository $hostingTypeRepo)
    {
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostingTypes",
     *      summary="Get a listing of the HostingTypes.",
     *      tags={"HostingType"},
     *      description="Get all HostingTypes",
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
     *                  @SWG\Items(ref="#/definitions/HostingType")
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
        $hostingTypes = $this->hostingTypeRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(HostingTypeResource::collection($hostingTypes), Lang::get('hosting_type.index_confirm'), $hostingTypes->total());
    }

    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/hostingTypes",
     *      summary="Store a newly created HostingType in storage",
     *      tags={"HostingType"},
     *      description="Store HostingType",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="HostingType that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/HostingType")
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
     *                  ref="#/definitions/HostingType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHostingTypeAPIRequest $request)
    {
        $input = $request->all();

        $hostingType = $this->hostingTypeRepository->create($input);

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.store_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostingTypes/{id}",
     *      summary="Display the specified HostingType",
     *      tags={"HostingType"},
     *      description="Get HostingType",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of HostingType",
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
     *                  ref="#/definitions/HostingType"
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
        /** @var HostingType $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.show_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Put(
     *      path="/hostingTypes/{id}",
     *      summary="Update the specified HostingType in storage",
     *      tags={"HostingType"},
     *      description="Update HostingType",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of HostingType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="HostingType that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/HostingType")
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
     *                  ref="#/definitions/HostingType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHostingTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var HostingType $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        $hostingType = $this->hostingTypeRepository->update($input, $id);

        return $this->sendResponse(new HostingTypeResource($hostingType), Lang::get('hosting_type.update_confirm'));
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/hostingTypes/{id}",
     *      summary="Remove the specified HostingType from storage",
     *      tags={"HostingType"},
     *      description="Delete HostingType",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of HostingType",
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
        /** @var HostingType $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError(Lang::get('hosting_type.not_found'));
        }

        $hostingType->delete();

        return $this->sendSuccess(Lang::get('hosting_type.destroy_confirm'));
    }
}

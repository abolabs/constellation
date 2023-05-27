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
use App\Http\Requests\API\CreateServiceVersionAPIRequest;
use App\Http\Requests\API\UpdateServiceVersionAPIRequest;
use App\Http\Resources\ServiceVersionResource;
use App\Models\ServiceVersion;
use App\Repositories\ServiceVersionRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ServiceVersionController.
 */
class ServiceVersionAPIController extends AppBaseController
{
    /** @var ServiceVersionRepository */
    private $serviceVersionRepository;

    public function __construct(ServiceVersionRepository $serviceVersionRepo)
    {
        $this->authorizeResource(ServiceVersion::class);
        $this->serviceVersionRepository = $serviceVersionRepo;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceVersions",
     *      summary="Get a listing of the ServiceVersions.",
     *      tags={"ServiceVersion"},
     *      description="Get all ServiceVersions",
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
     *                  @SWG\Items(ref="#/definitions/ServiceVersion")
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
        $serviceVersions = $this->serviceVersionRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );
        $serviceVersions->load('service');

        return $this->sendResponse(ServiceVersionResource::collection($serviceVersions), 'Service Versions retrieved successfully', $serviceVersions->total());
    }

    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/serviceVersions",
     *      summary="Store a newly created ServiceVersion in storage",
     *      tags={"ServiceVersion"},
     *      description="Store ServiceVersion",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceVersion that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/ServiceVersion")
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
     *                  ref="#/definitions/ServiceVersion"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateServiceVersionAPIRequest $request)
    {
        $input = $request->all();

        $serviceVersion = $this->serviceVersionRepository->create($input);

        return $this->sendResponse(new ServiceVersionResource($serviceVersion), 'Service Version saved successfully');
    }

    /**
     * @param  ServiceVersion $serviceVersion
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceVersions/{id}",
     *      summary="Display the specified ServiceVersion",
     *      tags={"ServiceVersion"},
     *      description="Get ServiceVersion",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceVersion",
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
     *                  ref="#/definitions/ServiceVersion"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        return $this->sendResponse(new ServiceVersionResource($serviceVersion), 'Service Version retrieved successfully');
    }

    /**
     * @param  ServiceVersion $serviceVersion
     * @return Response
     *
     * @SWG\Put(
     *      path="/serviceVersions/{id}",
     *      summary="Update the specified ServiceVersion in storage",
     *      tags={"ServiceVersion"},
     *      description="Update ServiceVersion",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceVersion",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceVersion that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/ServiceVersion")
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
     *                  ref="#/definitions/ServiceVersion"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(ServiceVersion $serviceVersion, UpdateServiceVersionAPIRequest $request)
    {
        $input = $request->all();

        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        $serviceVersion = $this->serviceVersionRepository->update($input, $serviceVersion->id);

        return $this->sendResponse(new ServiceVersionResource($serviceVersion), 'ServiceVersion updated successfully');
    }

    /**
     * @param  ServiceVersion $serviceVersion
     * @return Response
     *
     * @SWG\Delete(
     *      path="/serviceVersions/{id}",
     *      summary="Remove the specified ServiceVersion from storage",
     *      tags={"ServiceVersion"},
     *      description="Delete ServiceVersion",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceVersion",
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
    public function destroy(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        $serviceVersion->delete();

        return $this->sendSuccess('Service Version deleted successfully');
    }
}

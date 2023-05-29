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
use App\Http\Requests\API\CreateEnvironmentAPIRequest;
use App\Http\Requests\API\UpdateEnvironmentAPIRequest;
use App\Http\Resources\EnvironmentResource;
use App\Models\Environment;
use App\Repositories\EnvironmentRepository;
use Illuminate\Http\Request;
use Response;

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
     * @return Response
     *
     * @SWG\Get(
     *      path="/environments",
     *      summary="Get a listing of the Environments.",
     *      tags={"Environment"},
     *      description="Get all Environments",
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
     *                  @SWG\Items(ref="#/definitions/Environment")
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
     * @return Response
     *
     * @SWG\Post(
     *      path="/environments",
     *      summary="Store a newly created Environment in storage",
     *      tags={"Environment"},
     *      description="Store Environment",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Environment that should be stored",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Environment")
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
     *                  ref="#/definitions/Environment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEnvironmentAPIRequest $request)
    {
        $input = $request->all();

        $environment = $this->environmentRepository->create($input);

        return $this->sendResponse(new EnvironmentResource($environment), \Lang::get('environment.saved_confirm'));
    }

    /**
     * @param  Environment  $environment
     * @return Response
     *
     * @SWG\Get(
     *      path="/environments/{id}",
     *      summary="Display the specified Environment",
     *      tags={"Environment"},
     *      description="Get Environment",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environment",
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
     *                  ref="#/definitions/Environment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Environment $environment)
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
     * @param  Environment  $environment
     * @return Response
     *
     * @SWG\Put(
     *      path="/environments/{id}",
     *      summary="Update the specified Environment in storage",
     *      tags={"Environment"},
     *      description="Update Environment",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Environment that should be updated",
     *          required=false,
     *
     *          @SWG\Schema(ref="#/definitions/Environment")
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
     *                  ref="#/definitions/Environment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(Environment $environment, UpdateEnvironmentAPIRequest $request)
    {
        $input = $request->all();

        if (empty($environment)) {
            return $this->sendError(\Lang::get('environment.not_found'));
        }

        $environment = $this->environmentRepository->update($input, $environment->id);

        return $this->sendResponse(new EnvironmentResource($environment), \Lang::get('environment.update_confirm'));
    }

    /**
     * @param  Environment  $environment
     * @return Response
     *
     * @SWG\Delete(
     *      path="/environments/{id}",
     *      summary="Remove the specified Environment from storage",
     *      tags={"Environment"},
     *      description="Delete Environment",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Environment",
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
    public function destroy(Environment $environment)
    {
        if (empty($environment)) {
            return $this->sendError(\Lang::get('environment.not_found'));
        }

        $environment->delete();

        return $this->sendSuccess(\Lang::get('environment.delete_confirm'));
    }
}

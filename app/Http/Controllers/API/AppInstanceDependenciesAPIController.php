<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppInstanceDependenciesAPIRequest;
use App\Http\Requests\API\UpdateAppInstanceDependenciesAPIRequest;
use App\Models\AppInstanceDependencies;
use App\Repositories\AppInstanceDependenciesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppInstanceDependenciesResource;
use Response;

/**
 * Class AppInstanceDependenciesController
 * @package App\Http\Controllers\API
 */

class AppInstanceDependenciesAPIController extends AppBaseController
{
    /** @var  AppInstanceDependenciesRepository */
    private $appInstanceDependenciesRepository;

    public function __construct(AppInstanceDependenciesRepository $appInstanceDependenciesRepo)
    {
        $this->appInstanceDependenciesRepository = $appInstanceDependenciesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/appInstanceDependencies",
     *      summary="Get a listing of the AppInstanceDependencies.",
     *      tags={"AppInstanceDependencies"},
     *      description="Get all AppInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/AppInstanceDependencies")
     *              ),
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
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AppInstanceDependenciesResource::collection($appInstanceDependencies), 'App Instance Dependencies retrieved successfully');
    }

    /**
     * @param CreateAppInstanceDependenciesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/appInstanceDependencies",
     *      summary="Store a newly created AppInstanceDependencies in storage",
     *      tags={"AppInstanceDependencies"},
     *      description="Store AppInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AppInstanceDependencies that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AppInstanceDependencies")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/AppInstanceDependencies"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAppInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        $appInstanceDependencies = $this->appInstanceDependenciesRepository->create($input);

        return $this->sendResponse(new AppInstanceDependenciesResource($appInstanceDependencies), 'App Instance Dependencies saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/appInstanceDependencies/{id}",
     *      summary="Display the specified AppInstanceDependencies",
     *      tags={"AppInstanceDependencies"},
     *      description="Get AppInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppInstanceDependencies",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/AppInstanceDependencies"
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
        /** @var AppInstanceDependencies $appInstanceDependencies */
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            return $this->sendError('App Instance Dependencies not found');
        }

        return $this->sendResponse(new AppInstanceDependenciesResource($appInstanceDependencies), 'App Instance Dependencies retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAppInstanceDependenciesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/appInstanceDependencies/{id}",
     *      summary="Update the specified AppInstanceDependencies in storage",
     *      tags={"AppInstanceDependencies"},
     *      description="Update AppInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppInstanceDependencies",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AppInstanceDependencies that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AppInstanceDependencies")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/AppInstanceDependencies"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAppInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppInstanceDependencies $appInstanceDependencies */
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            return $this->sendError('App Instance Dependencies not found');
        }

        $appInstanceDependencies = $this->appInstanceDependenciesRepository->update($input, $id);

        return $this->sendResponse(new AppInstanceDependenciesResource($appInstanceDependencies), 'AppInstanceDependencies updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/appInstanceDependencies/{id}",
     *      summary="Remove the specified AppInstanceDependencies from storage",
     *      tags={"AppInstanceDependencies"},
     *      description="Delete AppInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppInstanceDependencies",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
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
        /** @var AppInstanceDependencies $appInstanceDependencies */
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            return $this->sendError('App Instance Dependencies not found');
        }

        $appInstanceDependencies->delete();

        return $this->sendSuccess('App Instance Dependencies deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateServiceInstanceDependenciesAPIRequest;
use App\Http\Requests\API\UpdateServiceInstanceDependenciesAPIRequest;
use App\Http\Resources\ServiceInstanceDependenciesResource;
use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceDependenciesRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ServiceInstanceDependenciesController.
 */
class ServiceInstanceDependenciesAPIController extends AppBaseController
{
    /** @var ServiceInstanceDependenciesRepository */
    private $serviceInstanceDependenciesRepository;

    public function __construct(ServiceInstanceDependenciesRepository $serviceInstanceDependenciesRepo)
    {
        $this->serviceInstanceDependenciesRepository = $serviceInstanceDependenciesRepo;
    }

    /**
     * @param  Request  $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceInstanceDependencies",
     *      summary="Get a listing of the ServiceInstanceDependencies.",
     *      tags={"ServiceInstanceDependencies"},
     *      description="Get all ServiceInstanceDependencies",
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
     *                  @SWG\Items(ref="#/definitions/ServiceInstanceDependencies")
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
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ServiceInstanceDependenciesResource::collection($serviceInstanceDependencies), 'Service Instance Dependencies retrieved successfully');
    }

    /**
     * @param  CreateServiceInstanceDependenciesAPIRequest  $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/serviceInstanceDependencies",
     *      summary="Store a newly created ServiceInstanceDependencies in storage",
     *      tags={"ServiceInstanceDependencies"},
     *      description="Store ServiceInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceInstanceDependencies that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceInstanceDependencies")
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
     *                  ref="#/definitions/ServiceInstanceDependencies"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateServiceInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->create($input);

        return $this->sendResponse(new ServiceInstanceDependenciesResource($serviceInstanceDependencies), 'Service Instance Dependencies saved successfully');
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceInstanceDependencies/{id}",
     *      summary="Display the specified ServiceInstanceDependencies",
     *      tags={"ServiceInstanceDependencies"},
     *      description="Get ServiceInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceInstanceDependencies",
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
     *                  ref="#/definitions/ServiceInstanceDependencies"
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
        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service Instance Dependencies not found');
        }

        return $this->sendResponse(new ServiceInstanceDependenciesResource($serviceInstanceDependencies), 'Service Instance Dependencies retrieved successfully');
    }

    /**
     * @param  int  $id
     * @param  UpdateServiceInstanceDependenciesAPIRequest  $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/serviceInstanceDependencies/{id}",
     *      summary="Update the specified ServiceInstanceDependencies in storage",
     *      tags={"ServiceInstanceDependencies"},
     *      description="Update ServiceInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceInstanceDependencies",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceInstanceDependencies that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceInstanceDependencies")
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
     *                  ref="#/definitions/ServiceInstanceDependencies"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateServiceInstanceDependenciesAPIRequest $request)
    {
        $input = $request->all();

        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service Instance Dependencies not found');
        }

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->update($input, $id);

        return $this->sendResponse(new ServiceInstanceDependenciesResource($serviceInstanceDependencies), 'ServiceInstanceDependencies updated successfully');
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/serviceInstanceDependencies/{id}",
     *      summary="Remove the specified ServiceInstanceDependencies from storage",
     *      tags={"ServiceInstanceDependencies"},
     *      description="Delete ServiceInstanceDependencies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceInstanceDependencies",
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
        /** @var ServiceInstanceDependencies $serviceInstanceDependencies */
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            return $this->sendError('Service Instance Dependencies not found');
        }

        $serviceInstanceDependencies->delete();

        return $this->sendSuccess('Service Instance Dependencies deleted successfully');
    }
}

<?php

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
        $this->serviceVersionRepository = $serviceVersionRepo;
    }

    /**
     * @param  Request  $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceVersions",
     *      summary="Get a listing of the ServiceVersions.",
     *      tags={"ServiceVersion"},
     *      description="Get all ServiceVersions",
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
     *                  @SWG\Items(ref="#/definitions/ServiceVersion")
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
     * @param  CreateServiceVersionAPIRequest  $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/serviceVersions",
     *      summary="Store a newly created ServiceVersion in storage",
     *      tags={"ServiceVersion"},
     *      description="Store ServiceVersion",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceVersion that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceVersion")
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
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/serviceVersions/{id}",
     *      summary="Display the specified ServiceVersion",
     *      tags={"ServiceVersion"},
     *      description="Get ServiceVersion",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceVersion",
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
    public function show($id)
    {
        /** @var ServiceVersion $serviceVersion */
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        return $this->sendResponse(new ServiceVersionResource($serviceVersion), 'Service Version retrieved successfully');
    }

    /**
     * @param  int  $id
     * @param  UpdateServiceVersionAPIRequest  $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/serviceVersions/{id}",
     *      summary="Update the specified ServiceVersion in storage",
     *      tags={"ServiceVersion"},
     *      description="Update ServiceVersion",
     *      produces={"application/json"},
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
     *          @SWG\Schema(ref="#/definitions/ServiceVersion")
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
    public function update($id, UpdateServiceVersionAPIRequest $request)
    {
        $input = $request->all();

        /** @var ServiceVersion $serviceVersion */
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        $serviceVersion = $this->serviceVersionRepository->update($input, $id);

        return $this->sendResponse(new ServiceVersionResource($serviceVersion), 'ServiceVersion updated successfully');
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/serviceVersions/{id}",
     *      summary="Remove the specified ServiceVersion from storage",
     *      tags={"ServiceVersion"},
     *      description="Delete ServiceVersion",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceVersion",
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
        /** @var ServiceVersion $serviceVersion */
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            return $this->sendError('Service Version not found');
        }

        $serviceVersion->delete();

        return $this->sendSuccess('Service Version deleted successfully');
    }
}

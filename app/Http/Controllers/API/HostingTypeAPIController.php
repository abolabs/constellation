<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateHostingTypeAPIRequest;
use App\Http\Requests\API\UpdateHostingTypeAPIRequest;
use App\Http\Resources\HostingTypeResource;
use App\Models\HostingType;
use App\Repositories\HostingTypeRepository;
use Illuminate\Http\Request;
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
     * @param  Request  $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostingTypes",
     *      summary="Get a listing of the HostingTypes.",
     *      tags={"HostingType"},
     *      description="Get all HostingTypes",
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
     *                  @SWG\Items(ref="#/definitions/HostingType")
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
        $hostingTypes = $this->hostingTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(HostingTypeResource::collection($hostingTypes), 'Hosting Types retrieved successfully');
    }

    /**
     * @param  CreateHostingTypeAPIRequest  $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/hostingTypes",
     *      summary="Store a newly created HostingType in storage",
     *      tags={"HostingType"},
     *      description="Store HostingType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="HostingType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/HostingType")
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

        return $this->sendResponse(new HostingTypeResource($hostingType), 'Hosting Type saved successfully');
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
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of HostingType",
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
            return $this->sendError('Hosting Type not found');
        }

        return $this->sendResponse(new HostingTypeResource($hostingType), 'Hosting Type retrieved successfully');
    }

    /**
     * @param  int  $id
     * @param  UpdateHostingTypeAPIRequest  $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/hostingTypes/{id}",
     *      summary="Update the specified HostingType in storage",
     *      tags={"HostingType"},
     *      description="Update HostingType",
     *      produces={"application/json"},
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
     *          @SWG\Schema(ref="#/definitions/HostingType")
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
            return $this->sendError('Hosting Type not found');
        }

        $hostingType = $this->hostingTypeRepository->update($input, $id);

        return $this->sendResponse(new HostingTypeResource($hostingType), 'HostingType updated successfully');
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
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of HostingType",
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
        /** @var HostingType $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError('Hosting Type not found');
        }

        $hostingType->delete();

        return $this->sendSuccess('Hosting Type deleted successfully');
    }
}

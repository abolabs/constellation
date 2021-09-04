<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createhosting_typeAPIRequest;
use App\Http\Requests\API\Updatehosting_typeAPIRequest;
use App\Models\hosting_type;
use App\Repositories\hosting_typeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\hosting_typeResource;
use Response;

/**
 * Class hosting_typeController
 * @package App\Http\Controllers\API
 */

class hosting_typeAPIController extends AppBaseController
{
    /** @var  hosting_typeRepository */
    private $hostingTypeRepository;

    public function __construct(hosting_typeRepository $hostingTypeRepo)
    {
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostingTypes",
     *      summary="Get a listing of the hosting_types.",
     *      tags={"hosting_type"},
     *      description="Get all hosting_types",
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
     *                  @SWG\Items(ref="#/definitions/hosting_type")
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

        return $this->sendResponse(hosting_typeResource::collection($hostingTypes), 'Hosting Types retrieved successfully');
    }

    /**
     * @param Createhosting_typeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/hostingTypes",
     *      summary="Store a newly created hosting_type in storage",
     *      tags={"hosting_type"},
     *      description="Store hosting_type",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="hosting_type that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/hosting_type")
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
     *                  ref="#/definitions/hosting_type"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Createhosting_typeAPIRequest $request)
    {
        $input = $request->all();

        $hostingType = $this->hostingTypeRepository->create($input);

        return $this->sendResponse(new hosting_typeResource($hostingType), 'Hosting Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostingTypes/{id}",
     *      summary="Display the specified hosting_type",
     *      tags={"hosting_type"},
     *      description="Get hosting_type",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of hosting_type",
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
     *                  ref="#/definitions/hosting_type"
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
        /** @var hosting_type $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError('Hosting Type not found');
        }

        return $this->sendResponse(new hosting_typeResource($hostingType), 'Hosting Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param Updatehosting_typeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/hostingTypes/{id}",
     *      summary="Update the specified hosting_type in storage",
     *      tags={"hosting_type"},
     *      description="Update hosting_type",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of hosting_type",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="hosting_type that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/hosting_type")
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
     *                  ref="#/definitions/hosting_type"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Updatehosting_typeAPIRequest $request)
    {
        $input = $request->all();

        /** @var hosting_type $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError('Hosting Type not found');
        }

        $hostingType = $this->hostingTypeRepository->update($input, $id);

        return $this->sendResponse(new hosting_typeResource($hostingType), 'hosting_type updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/hostingTypes/{id}",
     *      summary="Remove the specified hosting_type from storage",
     *      tags={"hosting_type"},
     *      description="Delete hosting_type",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of hosting_type",
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
        /** @var hosting_type $hostingType */
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            return $this->sendError('Hosting Type not found');
        }

        $hostingType->delete();

        return $this->sendSuccess('Hosting Type deleted successfully');
    }
}

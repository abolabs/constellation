<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHostingAPIRequest;
use App\Http\Requests\API\UpdateHostingAPIRequest;
use App\Models\Hosting;
use App\Repositories\HostingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\HostingResource;
use Response;

/**
 * Class HostingController
 * @package App\Http\Controllers\API
 */

class HostingAPIController extends AppBaseController
{
    /** @var  HostingRepository */
    private $hostingRepository;

    public function __construct(HostingRepository $hostingRepo)
    {
        $this->hostingRepository = $hostingRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostings",
     *      summary="Get a listing of the Hostings.",
     *      tags={"Hosting"},
     *      description="Get all Hostings",
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
     *                  @SWG\Items(ref="#/definitions/Hosting")
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
        $hostings = $this->hostingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(HostingResource::collection($hostings), 'Hostings retrieved successfully');
    }

    /**
     * @param CreateHostingAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/hostings",
     *      summary="Store a newly created Hosting in storage",
     *      tags={"Hosting"},
     *      description="Store Hosting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Hosting that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Hosting")
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
     *                  ref="#/definitions/Hosting"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHostingAPIRequest $request)
    {
        $input = $request->all();

        $hosting = $this->hostingRepository->create($input);

        return $this->sendResponse(new HostingResource($hosting), 'Hosting saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/hostings/{id}",
     *      summary="Display the specified Hosting",
     *      tags={"Hosting"},
     *      description="Get Hosting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Hosting",
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
     *                  ref="#/definitions/Hosting"
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
        /** @var Hosting $hosting */
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            return $this->sendError('Hosting not found');
        }

        return $this->sendResponse(new HostingResource($hosting), 'Hosting retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateHostingAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/hostings/{id}",
     *      summary="Update the specified Hosting in storage",
     *      tags={"Hosting"},
     *      description="Update Hosting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Hosting",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Hosting that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Hosting")
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
     *                  ref="#/definitions/Hosting"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHostingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Hosting $hosting */
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            return $this->sendError('Hosting not found');
        }

        $hosting = $this->hostingRepository->update($input, $id);

        return $this->sendResponse(new HostingResource($hosting), 'Hosting updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/hostings/{id}",
     *      summary="Remove the specified Hosting from storage",
     *      tags={"Hosting"},
     *      description="Delete Hosting",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Hosting",
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
        /** @var Hosting $hosting */
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            return $this->sendError('Hosting not found');
        }

        $hosting->delete();

        return $this->sendSuccess('Hosting deleted successfully');
    }
}
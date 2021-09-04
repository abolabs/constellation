<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateenvironnementAPIRequest;
use App\Http\Requests\API\UpdateenvironnementAPIRequest;
use App\Models\environnement;
use App\Repositories\environnementRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\environnementResource;
use Response;

/**
 * Class environnementController
 * @package App\Http\Controllers\API
 */

class environnementAPIController extends AppBaseController
{
    /** @var  environnementRepository */
    private $environnementRepository;

    public function __construct(environnementRepository $environnementRepo)
    {
        $this->environnementRepository = $environnementRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/environnements",
     *      summary="Get a listing of the environnements.",
     *      tags={"environnement"},
     *      description="Get all environnements",
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
     *                  @SWG\Items(ref="#/definitions/environnement")
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
        $environnements = $this->environnementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(environnementResource::collection($environnements), 'Environnements retrieved successfully');
    }

    /**
     * @param CreateenvironnementAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/environnements",
     *      summary="Store a newly created environnement in storage",
     *      tags={"environnement"},
     *      description="Store environnement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="environnement that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/environnement")
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
     *                  ref="#/definitions/environnement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateenvironnementAPIRequest $request)
    {
        $input = $request->all();

        $environnement = $this->environnementRepository->create($input);

        return $this->sendResponse(new environnementResource($environnement), 'Environnement saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/environnements/{id}",
     *      summary="Display the specified environnement",
     *      tags={"environnement"},
     *      description="Get environnement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of environnement",
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
     *                  ref="#/definitions/environnement"
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
        /** @var environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError('Environnement not found');
        }

        return $this->sendResponse(new environnementResource($environnement), 'Environnement retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateenvironnementAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/environnements/{id}",
     *      summary="Update the specified environnement in storage",
     *      tags={"environnement"},
     *      description="Update environnement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of environnement",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="environnement that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/environnement")
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
     *                  ref="#/definitions/environnement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateenvironnementAPIRequest $request)
    {
        $input = $request->all();

        /** @var environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError('Environnement not found');
        }

        $environnement = $this->environnementRepository->update($input, $id);

        return $this->sendResponse(new environnementResource($environnement), 'environnement updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/environnements/{id}",
     *      summary="Remove the specified environnement from storage",
     *      tags={"environnement"},
     *      description="Delete environnement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of environnement",
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
        /** @var environnement $environnement */
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            return $this->sendError('Environnement not found');
        }

        $environnement->delete();

        return $this->sendSuccess('Environnement deleted successfully');
    }
}

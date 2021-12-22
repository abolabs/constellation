<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateApplicationAPIRequest;
use App\Http\Requests\API\UpdateApplicationAPIRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ApplicationController.
 */
class ApplicationAPIController extends AppBaseController
{
    /** @var ApplicationRepository */
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepo)
    {
        $this->applicationRepository = $applicationRepo;
    }

    /**
     * @param  Request  $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/applications",
     *      summary="Get a listing of the Applications.",
     *      tags={"Application"},
     *      description="Get all Applications",
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
     *                  @SWG\Items(ref="#/definitions/Application")
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
        $applications = $this->applicationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ApplicationResource::collection($applications), 'Applications retrieved successfully');
    }

    /**
     * @param  CreateApplicationAPIRequest  $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/applications",
     *      summary="Store a newly created Application in storage",
     *      tags={"Application"},
     *      description="Store Application",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Application that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Application")
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
     *                  ref="#/definitions/Application"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateApplicationAPIRequest $request)
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        return $this->sendResponse(new ApplicationResource($application), 'Application saved successfully');
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/applications/{id}",
     *      summary="Display the specified Application",
     *      tags={"Application"},
     *      description="Get Application",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
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
     *                  ref="#/definitions/Application"
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
        /** @var Application $application */
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            return $this->sendError('Application not found');
        }

        return $this->sendResponse(new ApplicationResource($application), 'Application retrieved successfully');
    }

    /**
     * @param  int  $id
     * @param  UpdateApplicationAPIRequest  $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/applications/{id}",
     *      summary="Update the specified Application in storage",
     *      tags={"Application"},
     *      description="Update Application",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Application that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Application")
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
     *                  ref="#/definitions/Application"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateApplicationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Application $application */
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            return $this->sendError('Application not found');
        }

        $application = $this->applicationRepository->update($input, $id);

        return $this->sendResponse(new ApplicationResource($application), 'Application updated successfully');
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/applications/{id}",
     *      summary="Remove the specified Application from storage",
     *      tags={"Application"},
     *      description="Delete Application",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Application",
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
        /** @var Application $application */
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            return $this->sendError('Application not found');
        }

        $application->delete();

        return $this->sendSuccess('Application deleted successfully');
    }
}

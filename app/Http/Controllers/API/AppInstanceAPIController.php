<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppInstanceAPIRequest;
use App\Http\Requests\API\UpdateAppInstanceAPIRequest;
use App\Models\AppInstance;
use App\Repositories\AppInstanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppInstanceResource;
use Response;

/**
 * Class AppInstanceController
 * @package App\Http\Controllers\API
 */

class AppInstanceAPIController extends AppBaseController
{
    /** @var  AppInstanceRepository */
    private $appInstanceRepository;

    public function __construct(AppInstanceRepository $appInstanceRepo)
    {
        $this->appInstanceRepository = $appInstanceRepo;
    }

    /**
     * Display a listing of the AppInstance.
     * GET|HEAD /appInstances
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $appInstances = $this->appInstanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AppInstanceResource::collection($appInstances), 'App Instances retrieved successfully');
    }

    /**
     * Store a newly created AppInstance in storage.
     * POST /appInstances
     *
     * @param CreateAppInstanceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppInstanceAPIRequest $request)
    {
        $input = $request->all();

        $appInstance = $this->appInstanceRepository->create($input);

        return $this->sendResponse(new AppInstanceResource($appInstance), 'App Instance saved successfully');
    }

    /**
     * Display the specified AppInstance.
     * GET|HEAD /appInstances/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppInstance $appInstance */
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            return $this->sendError('App Instance not found');
        }

        return $this->sendResponse(new AppInstanceResource($appInstance), 'App Instance retrieved successfully');
    }

    /**
     * Update the specified AppInstance in storage.
     * PUT/PATCH /appInstances/{id}
     *
     * @param int $id
     * @param UpdateAppInstanceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppInstanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppInstance $appInstance */
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            return $this->sendError('App Instance not found');
        }

        $appInstance = $this->appInstanceRepository->update($input, $id);

        return $this->sendResponse(new AppInstanceResource($appInstance), 'AppInstance updated successfully');
    }

    /**
     * Remove the specified AppInstance from storage.
     * DELETE /appInstances/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppInstance $appInstance */
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            return $this->sendError('App Instance not found');
        }

        $appInstance->delete();

        return $this->sendSuccess('App Instance deleted successfully');
    }
}

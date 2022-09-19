<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateServiceInstanceAPIRequest;
use App\Http\Requests\API\UpdateServiceInstanceAPIRequest;
use App\Http\Resources\ServiceInstanceResource;
use App\Models\ServiceInstance;
use App\Repositories\ServiceInstanceRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ServiceInstanceController.
 */
class ServiceInstanceAPIController extends AppBaseController
{
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;

    public function __construct(ServiceInstanceRepository $serviceInstanceRepo)
    {
        $this->serviceInstanceRepository = $serviceInstanceRepo;
    }

    /**
     * Display a listing of the ServiceInstance.
     * GET|HEAD /serviceInstances.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceInstances = $this->serviceInstanceRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );
        return $this->sendResponse(ServiceInstanceResource::collection($serviceInstances), 'Service Instances retrieved successfully',$serviceInstances->total());
    }

    /**
     * Store a newly created ServiceInstance in storage.
     * POST /serviceInstances.
     *
     * @param  CreateServiceInstanceAPIRequest  $request
     * @return Response
     */
    public function store(CreateServiceInstanceAPIRequest $request)
    {
        $input = $request->all();

        $serviceInstance = $this->serviceInstanceRepository->create($input);

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'Service Instance saved successfully');
    }

    /**
     * Display the specified ServiceInstance.
     * GET|HEAD /serviceInstances/{id}.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        /** @var ServiceInstance $serviceInstance */
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'Service Instance retrieved successfully');
    }

    /**
     * Update the specified ServiceInstance in storage.
     * PUT/PATCH /serviceInstances/{id}.
     *
     * @param  int  $id
     * @param  UpdateServiceInstanceAPIRequest  $request
     * @return Response
     */
    public function update($id, UpdateServiceInstanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var ServiceInstance $serviceInstance */
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance = $this->serviceInstanceRepository->update($input, $id);

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'ServiceInstance updated successfully');
    }

    /**
     * Remove the specified ServiceInstance from storage.
     * DELETE /serviceInstances/{id}.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var ServiceInstance $serviceInstance */
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance->delete();

        return $this->sendSuccess('Service Instance deleted successfully');
    }
}

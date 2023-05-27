<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateServiceInstanceAPIRequest;
use App\Http\Requests\API\UpdateServiceInstanceAPIRequest;
use App\Http\Resources\ServiceInstanceResource;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
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
        $this->authorizeResource(ServiceInstance::class);
        $this->serviceInstanceRepository = $serviceInstanceRepo;
    }

    /**
     * Display a listing of the ServiceInstance.
     * GET|HEAD /serviceInstances.
     *
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

        return $this->sendResponse(ServiceInstanceResource::collection($serviceInstances), 'Service Instances retrieved successfully', $serviceInstances->total());
    }

    /**
     * Store a newly created ServiceInstance in storage.
     * POST /serviceInstances.
     *
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
     * GET|HEAD /serviceInstances/{serviceInstance}.
     *
     * @param  ServiceInstance  $serviceInstance
     * @return Response
     */
    public function show(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $instanceDependencies = ServiceInstanceDependencies::where('instance_id', $serviceInstance->id)
            ->with([
                'serviceInstanceDep',
                'serviceInstanceDep.hosting',
                'serviceInstanceDep.application',
                'serviceInstanceDep.serviceVersion',
                'serviceInstanceDep.serviceVersion.service',
            ])->get();

        $instanceDependenciesSource = ServiceInstanceDependencies::where('instance_dep_id', $serviceInstance->id)
            ->with([
                'serviceInstance',
                'serviceInstance.hosting',
                'serviceInstance.application',
                'serviceInstance.serviceVersion',
                'serviceInstance.serviceVersion.service',
            ])->get();

        return $this->sendResponse(
            (new ServiceInstanceResource($serviceInstance))->additional([
                'instanceDependencies' => $instanceDependencies,
                'instanceDependenciesSource' => $instanceDependenciesSource,
            ]),
            'Service Instance retrieved successfully'
        );
    }

    /**
     * Update the specified ServiceInstance in storage.
     * PUT/PATCH /serviceInstances/{serviceInstance}.
     *
     * @param  ServiceInstance $serviceInstance
     * @return Response
     */
    public function update(ServiceInstance $serviceInstance, UpdateServiceInstanceAPIRequest $request)
    {
        $input = $request->all();

        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance = $this->serviceInstanceRepository->update($input, $serviceInstance->id);

        return $this->sendResponse(new ServiceInstanceResource($serviceInstance), 'ServiceInstance updated successfully');
    }

    /**
     * Remove the specified ServiceInstance from storage.
     * DELETE /serviceInstances/{serviceInstance}.
     *
     * @param  ServiceInstance  $serviceInstance
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            return $this->sendError('Service Instance not found');
        }

        $serviceInstance->delete();

        return $this->sendSuccess('Service Instance deleted successfully');
    }
}

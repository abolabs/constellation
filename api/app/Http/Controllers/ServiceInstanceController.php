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

namespace App\Http\Controllers;

use App\DataTables\ServiceInstanceDataTable;
use App\Http\Requests\CreateServiceInstanceRequest;
use App\Http\Requests\UpdateServiceInstanceRequest;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class ServiceInstanceController extends AppBaseController
{
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;

    public function __construct(ServiceInstanceRepository $serviceInstanceRepo)
    {
        $this->authorizeResource(ServiceInstance::class, 'serviceInstance');
        $this->serviceInstanceRepository = $serviceInstanceRepo;
    }

    /**
     * Display a listing of the ServiceInstance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(ServiceInstanceDataTable $serviceInstanceDataTable)
    {
        return $serviceInstanceDataTable->render('service_instances.index');
    }

    /**
     * Show the form for creating a new ServiceInstance.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_instances.create');
    }

    /**
     * Store a newly created ServiceInstance in storage.
     *
     * @param  CreateServiceInstanceRequest  $request
     * @return Response
     */
    public function store(CreateServiceInstanceRequest $request)
    {
        $input = $request->all();

        $this->serviceInstanceRepository->create($input);

        Flash::success('Service Instance saved successfully.');

        if (! empty($input['redirect_to_back'])) {
            return back()->withInput();
        }

        return redirect(route('serviceInstances.index'));
    }

    /**
     * Display the specified ServiceInstance.
     *
     * @param  ServiceInstance  $serviceInstance
     * @return Response
     */
    public function show(ServiceInstance $serviceInstance)
    {
        $serviceInstance->load(['application', 'hosting', 'environnement', 'serviceVersion', 'serviceVersion.service']);

        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        $instanceDependencies = ServiceInstanceDependencies::where('instance_id', $serviceInstance->id)
            ->with(
                'serviceInstanceDep',
                'serviceInstanceDep.hosting',
                'serviceInstanceDep.application',
                'serviceInstanceDep.serviceVersion',
                'serviceInstanceDep.serviceVersion.service',
            )->get();

        $instanceDependenciesSource = ServiceInstanceDependencies::where('instance_dep_id', $serviceInstance->id)
            ->with(
                'serviceInstance',
                'serviceInstanceDep.hosting',
                'serviceInstance.application',
                'serviceInstance.serviceVersion',
                'serviceInstance.serviceVersion.service',
            )->get();

        return view('service_instances.show')
                    ->with('serviceInstance', $serviceInstance)
                    ->with('instanceDependencies', $instanceDependencies)
                    ->with('instanceDependenciesSource', $instanceDependenciesSource);
    }

    /**
     * Show the form for editing the specified ServiceInstance.
     *
     * @param  ServiceInstance  $serviceInstance
     * @return Response
     */
    public function edit(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        return view('service_instances.edit')->with('serviceInstance', $serviceInstance);
    }

    /**
     * Update the specified ServiceInstance in storage.
     *
     * @param  ServiceInstance  $serviceInstance
     * @param  UpdateServiceInstanceRequest  $request
     * @return Response
     */
    public function update(ServiceInstance $serviceInstance, UpdateServiceInstanceRequest $request)
    {
        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }
        $defaultInputs = [
            'statut' => false,
        ];

        $serviceInstance = $this->serviceInstanceRepository->update(array_merge($defaultInputs, $request->all()), $serviceInstance->id);

        Flash::success('Service Instance updated successfully.');

        return redirect()->route('serviceInstances.show', ['serviceInstance' => $serviceInstance->id]);
    }

    /**
     * Remove the specified ServiceInstance from storage.
     *
     * @param  ServiceInstance  $serviceInstance
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy(ServiceInstance $serviceInstance)
    {
        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        $this->serviceInstanceRepository->delete($serviceInstance->id);

        Flash::success('Service Instance deleted successfully.');

        return redirect(route('serviceInstances.index'));
    }
}

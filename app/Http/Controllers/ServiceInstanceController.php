<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceInstanceDataTable;
use App\Http\Requests\CreateServiceInstanceRequest;
use App\Http\Requests\UpdateServiceInstanceRequest;
use App\Repositories\ServiceInstanceRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\ServiceInstanceDependencies;
use Illuminate\Http\Request;
use Flash;
use Response;

class ServiceInstanceController extends AppBaseController
{
    /** @var  ServiceInstanceRepository */
    private $serviceInstanceRepository;

    public function __construct(ServiceInstanceRepository $serviceInstanceRepo)
    {
        $this->serviceInstanceRepository = $serviceInstanceRepo;
    }

    /**
     * Display a listing of the ServiceInstance.
     *
     * @param Request $request
     *
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
     * @param CreateServiceInstanceRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceInstanceRequest $request)
    {
        $input = $request->all();

        $serviceInstance = $this->serviceInstanceRepository->create($input);

        Flash::success('Service Instance saved successfully.');

        if(!empty($input['redirect_to_back'])){
            return back()->withInput();
        }
        return redirect(route('serviceInstances.index'));
    }

    /**
     * Display the specified ServiceInstance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceInstance = $this->serviceInstanceRepository->find($id);
        $serviceInstance->load(['application','hosting','environnement','serviceVersion','serviceVersion.service']);

        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        $instanceDependencies = ServiceInstanceDependencies::where('instance_id', $id)
            ->with(
                'serviceInstanceDep',
                'serviceInstanceDep.hosting',
                'serviceInstanceDep.application',
                'serviceInstanceDep.serviceVersion',
                'serviceInstanceDep.serviceVersion.service',
            )->get();

        $instanceDependenciesSource = ServiceInstanceDependencies::where('instance_dep_id', $id)
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
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        return view('service_instances.edit')->with('serviceInstance', $serviceInstance);
    }

    /**
     * Update the specified ServiceInstance in storage.
     *
     * @param int $id
     * @param UpdateServiceInstanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceInstanceRequest $request)
    {
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }
        $defaultInputs = [
            "statut" => false
        ];

        $serviceInstance = $this->serviceInstanceRepository->update(array_merge($defaultInputs,$request->all()), $id);

        Flash::success('Service Instance updated successfully.');

        return redirect(route('serviceInstances.index'));
    }

    /**
     * Remove the specified ServiceInstance from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceInstance = $this->serviceInstanceRepository->find($id);

        if (empty($serviceInstance)) {
            Flash::error('Service Instance not found');

            return redirect(route('serviceInstances.index'));
        }

        $this->serviceInstanceRepository->delete($id);

        Flash::success('Service Instance deleted successfully.');

        return redirect(route('serviceInstances.index'));
    }
}

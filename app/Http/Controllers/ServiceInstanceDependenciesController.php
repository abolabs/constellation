<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceInstanceDependenciesDataTable;
use App\Http\Requests\CreateServiceInstanceDependenciesRequest;
use App\Http\Requests\UpdateServiceInstanceDependenciesRequest;
use App\Repositories\ServiceInstanceDependenciesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class ServiceInstanceDependenciesController extends AppBaseController
{
    /** @var  ServiceInstanceDependenciesRepository */
    private $serviceInstanceDependenciesRepository;

    public function __construct(ServiceInstanceDependenciesRepository $serviceInstanceDependenciesRepo)
    {
        $this->serviceInstanceDependenciesRepository = $serviceInstanceDependenciesRepo;
    }

    /**
     * Display a listing of the ServiceInstanceDependencies.
     *
     * @param ServiceInstanceDependenciesDataTable $serviceInstanceDependenciesDataTable
     * @return Response
     */
    public function index(ServiceInstanceDependenciesDataTable $serviceInstanceDependenciesDataTable)
    {
        return $serviceInstanceDependenciesDataTable->render('service_instance_dependencies.index');
    }

    /**
     * Show the form for creating a new ServiceInstanceDependencies.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_instance_dependencies.create');
    }

    /**
     * Store a newly created ServiceInstanceDependencies in storage.
     *
     * @param CreateServiceInstanceDependenciesRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceInstanceDependenciesRequest $request)
    {
        $input = $request->all();

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->create($input);

        Flash::success('Service Instance Dependencies saved successfully.');

        if(!empty($input['redirect_to_back'])){
            return back()->withInput();
        }

        return redirect(route('serviceInstanceDependencies.index'));
    }

    /**
     * Display the specified ServiceInstanceDependencies.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            Flash::error('Service Instance Dependencies not found');

            return redirect(route('serviceInstanceDependencies.index'));
        }

        return view('service_instance_dependencies.show')->with('serviceInstanceDependencies', $serviceInstanceDependencies);
    }

    /**
     * Show the form for editing the specified ServiceInstanceDependencies.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            Flash::error('Service Instance Dependencies not found');

            return redirect(route('serviceInstanceDependencies.index'));
        }

        return view('service_instance_dependencies.edit')->with('serviceInstanceDependencies', $serviceInstanceDependencies);
    }

    /**
     * Update the specified ServiceInstanceDependencies in storage.
     *
     * @param  int              $id
     * @param UpdateServiceInstanceDependenciesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceInstanceDependenciesRequest $request)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            Flash::error('Service Instance Dependencies not found');

            return redirect(route('serviceInstanceDependencies.index'));
        }

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->update($request->all(), $id);

        Flash::success('Service Instance Dependencies updated successfully.');

        return redirect(route('serviceInstanceDependencies.index'));
    }

    /**
     * Remove the specified ServiceInstanceDependencies from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $input = $request->all();
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            Flash::error('Service Instance Dependencies not found');

            return redirect(route('serviceInstanceDependencies.index'));
        }

        $this->serviceInstanceDependenciesRepository->delete($id);

        Flash::success('Service Instance Dependencies deleted successfully.');
        if(!empty($input['redirect_to_back'])){
            return back()->withInput();
        }

        return redirect(route('serviceInstanceDependencies.index'));
    }
}

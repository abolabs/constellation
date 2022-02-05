<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceVersionDependenciesDataTable;
use App\Http\Requests\CreateServiceVersionDependenciesRequest;
use App\Http\Requests\UpdateServiceVersionDependenciesRequest;
use App\Repositories\ServiceVersionDependenciesRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class ServiceVersionDependenciesController extends AppBaseController
{
    /** @var ServiceVersionDependenciesRepository */
    private $serviceVersionDependenciesRepository;

    public function __construct(ServiceVersionDependenciesRepository $serviceVersionDependenciesRepo)
    {
        $this->serviceVersionDependenciesRepository = $serviceVersionDependenciesRepo;
    }

    /**
     * Display a listing of the ServiceVersionDependencies.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(ServiceVersionDependenciesDataTable $serviceVersionDep)
    {
        return $serviceVersionDep->render('service_version_dependencies.index');
    }

    /**
     * Show the form for creating a new ServiceVersionDependencies.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_version_dependencies.create');
    }

    /**
     * Store a newly created ServiceVersionDependencies in storage.
     *
     * @param  CreateServiceVersionDependenciesRequest  $request
     * @return Response
     */
    public function store(CreateServiceVersionDependenciesRequest $request)
    {
        $input = $request->all();

        $this->serviceVersionDependenciesRepository->create($input);

        Flash::success('Service Version Dependencies saved successfully.');

        return redirect(route('serviceVersionDependencies.index'));
    }

    /**
     * Display the specified ServiceVersionDependencies.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            Flash::error('Service Version Dependencies not found');

            return redirect(route('serviceVersionDependencies.index'));
        }

        return view('service_version_dependencies.show')->with('serviceVersionDependencies', $serviceVersionDependencies);
    }

    /**
     * Show the form for editing the specified ServiceVersionDependencies.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            Flash::error('Service Version Dependencies not found');

            return redirect(route('serviceVersionDependencies.index'));
        }

        return view('service_version_dependencies.edit')->with('serviceVersionDependencies', $serviceVersionDependencies);
    }

    /**
     * Update the specified ServiceVersionDependencies in storage.
     *
     * @param  int  $id
     * @param  UpdateServiceVersionDependenciesRequest  $request
     * @return Response
     */
    public function update($id, UpdateServiceVersionDependenciesRequest $request)
    {
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            Flash::error('Service Version Dependencies not found');

            return redirect(route('serviceVersionDependencies.index'));
        }

        $this->serviceVersionDependenciesRepository->update($request->all(), $id);

        Flash::success('Service Version Dependencies updated successfully.');

        return redirect(route('serviceVersionDependencies.index'));
    }

    /**
     * Remove the specified ServiceVersionDependencies from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            Flash::error('Service Version Dependencies not found');

            return redirect(route('serviceVersionDependencies.index'));
        }

        $this->serviceVersionDependenciesRepository->delete($id);

        Flash::success('Service Version Dependencies deleted successfully.');

        return redirect(route('serviceVersionDependencies.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\AppInstanceDependenciesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAppInstanceDependenciesRequest;
use App\Http\Requests\UpdateAppInstanceDependenciesRequest;
use App\Repositories\AppInstanceDependenciesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AppInstanceDependenciesController extends AppBaseController
{
    /** @var  AppInstanceDependenciesRepository */
    private $appInstanceDependenciesRepository;

    public function __construct(AppInstanceDependenciesRepository $appInstanceDependenciesRepo)
    {
        $this->appInstanceDependenciesRepository = $appInstanceDependenciesRepo;
    }

    /**
     * Display a listing of the AppInstanceDependencies.
     *
     * @param AppInstanceDependenciesDataTable $appInstanceDependenciesDataTable
     * @return Response
     */
    public function index(AppInstanceDependenciesDataTable $appInstanceDependenciesDataTable)
    {
        return $appInstanceDependenciesDataTable->render('app_instance_dependencies.index');
    }

    /**
     * Show the form for creating a new AppInstanceDependencies.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_instance_dependencies.create');
    }

    /**
     * Store a newly created AppInstanceDependencies in storage.
     *
     * @param CreateAppInstanceDependenciesRequest $request
     *
     * @return Response
     */
    public function store(CreateAppInstanceDependenciesRequest $request)
    {
        $input = $request->all();

        $appInstanceDependencies = $this->appInstanceDependenciesRepository->create($input);

        Flash::success('App Instance Dependencies saved successfully.');

        return redirect(route('appInstanceDependencies.index'));
    }

    /**
     * Display the specified AppInstanceDependencies.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            Flash::error('App Instance Dependencies not found');

            return redirect(route('appInstanceDependencies.index'));
        }

        return view('app_instance_dependencies.show')->with('appInstanceDependencies', $appInstanceDependencies);
    }

    /**
     * Show the form for editing the specified AppInstanceDependencies.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            Flash::error('App Instance Dependencies not found');

            return redirect(route('appInstanceDependencies.index'));
        }

        return view('app_instance_dependencies.edit')->with('appInstanceDependencies', $appInstanceDependencies);
    }

    /**
     * Update the specified AppInstanceDependencies in storage.
     *
     * @param  int              $id
     * @param UpdateAppInstanceDependenciesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppInstanceDependenciesRequest $request)
    {
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            Flash::error('App Instance Dependencies not found');

            return redirect(route('appInstanceDependencies.index'));
        }

        $appInstanceDependencies = $this->appInstanceDependenciesRepository->update($request->all(), $id);

        Flash::success('App Instance Dependencies updated successfully.');

        return redirect(route('appInstanceDependencies.index'));
    }

    /**
     * Remove the specified AppInstanceDependencies from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appInstanceDependencies = $this->appInstanceDependenciesRepository->find($id);

        if (empty($appInstanceDependencies)) {
            Flash::error('App Instance Dependencies not found');

            return redirect(route('appInstanceDependencies.index'));
        }

        $this->appInstanceDependenciesRepository->delete($id);

        Flash::success('App Instance Dependencies deleted successfully.');

        return redirect(route('appInstanceDependencies.index'));
    }
}

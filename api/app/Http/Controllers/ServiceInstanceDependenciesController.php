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

use App\DataTables\ServiceInstanceDependenciesDataTable;
use App\Http\Requests\CreateServiceInstanceDependenciesRequest;
use App\Http\Requests\UpdateServiceInstanceDependenciesRequest;
use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceDependenciesRepository;
use Flash;
use Illuminate\Http\Request;
use Response;
use Lang;

class ServiceInstanceDependenciesController extends AppBaseController
{
    /** @var ServiceInstanceDependenciesRepository */
    private $serviceInstanceDependenciesRepository;

    public function __construct(ServiceInstanceDependenciesRepository $serviceInstanceDependenciesRepo)
    {
        $this->serviceInstanceDependenciesRepository = $serviceInstanceDependenciesRepo;
    }

    /**
     * Display a listing of the ServiceInstanceDependencies.
     *
     * @param  ServiceInstanceDependenciesDataTable  $serviceInstanceDependenciesDataTable
     * @return Response
     */
    public function index(ServiceInstanceDependenciesDataTable $serviceInstanceDependenciesDataTable)
    {
        $this->authorize('viewAny', ServiceInstanceDependencies::class);

        return $serviceInstanceDependenciesDataTable->render('service_instance_dependencies.index');
    }

    /**
     * Show the form for creating a new ServiceInstanceDependencies.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', ServiceInstanceDependencies::class);

        return view('service_instance_dependencies.create');
    }

    /**
     * Store a newly created ServiceInstanceDependencies in storage.
     *
     * @param  CreateServiceInstanceDependenciesRequest  $request
     * @return Response
     */
    public function store(CreateServiceInstanceDependenciesRequest $request)
    {
        $this->authorize('create', ServiceInstanceDependencies::class);
        $input = $request->all();

        $this->serviceInstanceDependenciesRepository->create($input);

        Flash::success('Service Instance Dependencies saved successfully.');

        if (! empty($input['redirect_to_back'])) {
            return back()->withInput();
        }

        return redirect(route('serviceInstanceDependencies.index'));
    }

    /**
     * Display the specified ServiceInstanceDependencies.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);

        if (empty($serviceInstanceDependencies)) {
            Flash::error(Lang::get('service_instance_dependencies.not_found'));

            return redirect(route('serviceInstanceDependencies.index'));
        }
        $this->authorize('view', $serviceInstanceDependencies);

        return view('service_instance_dependencies.show')->with('serviceInstanceDependencies', $serviceInstanceDependencies);
    }

    /**
     * Show the form for editing the specified ServiceInstanceDependencies.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);
        $this->authorize('update', $serviceInstanceDependencies);
        $serviceInstanceDependencies->load('serviceInstance');
        $serviceInstanceDependencies->load('serviceInstance.serviceVersion');

        if (empty($serviceInstanceDependencies)) {
            Flash::error(Lang::get('service_instance_dependencies.not_found'));

            return redirect(route('serviceInstanceDependencies.index'));
        }

        return view('service_instance_dependencies.edit')->with('serviceInstanceDependencies', $serviceInstanceDependencies);
    }

    /**
     * Update the specified ServiceInstanceDependencies in storage.
     *
     * @param  int  $id
     * @param  UpdateServiceInstanceDependenciesRequest  $request
     * @return Response
     */
    public function update(int $id, UpdateServiceInstanceDependenciesRequest $request)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);
        $this->authorize('update', $serviceInstanceDependencies);
        $input = $request->all();

        if (empty($serviceInstanceDependencies)) {
            Flash::error(Lang::get('service_instance_dependencies.not_found'));

            return redirect(route('serviceInstanceDependencies.index'));
        }

        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->update($request->all(), $serviceInstanceDependencies->id);

        Flash::success('Service Instance Dependencies updated successfully.');

        if (! empty($input['redirect_to_back'])) {
            return back()->withInput();
        }

        return redirect(route('serviceInstanceDependencies.index'));
    }

    /**
     * Remove the specified ServiceInstanceDependencies from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, int $id)
    {
        $serviceInstanceDependencies = $this->serviceInstanceDependenciesRepository->find($id);
        $this->authorize('delete', $serviceInstanceDependencies);
        $input = $request->all();

        if (empty($serviceInstanceDependencies)) {
            Flash::error(Lang::get('service_instance_dependencies.not_found'));

            return redirect(route('serviceInstanceDependencies.index'));
        }

        $this->serviceInstanceDependenciesRepository->delete($serviceInstanceDependencies->id);

        Flash::success('Service Instance Dependencies deleted successfully.');
        if (! empty($input['redirect_to_back'])) {
            return back()->withInput();
        }

        return redirect(route('serviceInstanceDependencies.index'));
    }
}

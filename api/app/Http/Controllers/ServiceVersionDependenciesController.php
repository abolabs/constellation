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

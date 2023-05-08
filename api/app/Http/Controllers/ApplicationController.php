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

use App\DataTables\ApplicationDataTable;
use App\Http\Requests\CreateApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\Environnement;
use App\Models\ServiceInstance;
use App\Repositories\ApplicationRepository;
use Flash;
use Lang;
use Response;

class ApplicationController extends AppBaseController
{
    /** @var ApplicationRepository */
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepo)
    {
        $this->authorizeResource(Application::class);
        $this->applicationRepository = $applicationRepo;
    }

    /**
     * Display a listing of the Application.
     *
     * @return Response
     */
    public function index(ApplicationDataTable $applicationDataTable)
    {
        return $applicationDataTable->render('applications.index');
    }

    /**
     * Show the form for creating a new Application.
     *
     * @return Response
     */
    public function create()
    {
        return view('applications.create');
    }

    /**
     * Store a newly created Application in storage.
     *
     * @return Response
     */
    public function store(CreateApplicationRequest $request)
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        Flash::success(Lang::get('application.saved_confirm'));

        return redirect(route('applications.show', $application->id));
    }

    /**
     * Display the specified Application.
     *
     * @return Response
     */
    public function show(Application $application)
    {
        $serviceInstances = ServiceInstance::where('application_id', $application->id)->with(['serviceVersion', 'serviceVersion.service', 'environnement'])->orderBy('environnement_id')->get();

        $countByEnv = Environnement::withCount(['serviceInstances' => function ($query) use ($application) {
            $query->where('application_id', $application->id);
        }])
            ->join('service_instance', 'environnement.id', '=', 'service_instance.environnement_id')
            ->where('service_instance.application_id', $application->id)
            ->get()->keyBy('id')->toArray();

        if (empty($application)) {
            Flash::error(Lang::get('application.not_found'));

            return redirect(route('applications.index'));
        }

        return view('applications.show')->with('application', $application)
            ->with('serviceInstances', $serviceInstances)
            ->with('countByEnv', $countByEnv);
    }

    /**
     * Show the form for editing the specified Application.
     *
     * @return Response
     */
    public function edit(Application $application)
    {
        if (empty($application)) {
            Flash::error(Lang::get('application.not_found'));

            return redirect(route('applications.index'));
        }

        return view('applications.edit')->with('application', $application);
    }

    /**
     * Update the specified Application in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Application $application, UpdateApplicationRequest $request)
    {
        if (empty($application)) {
            Flash::error(Lang::get('application.not_found'));

            return redirect(route('applications.index'));
        }

        $application = $this->applicationRepository->update($request->all(), $application->id);

        Flash::success(Lang::get('application.update_confirm'));

        return redirect(route('applications.index'));
    }

    /**
     * Remove the specified Application from storage.
     *
     * @return Response
     */
    public function destroy(Application $application)
    {
        if (empty($application)) {
            Flash::error(Lang::get('application.not_found'));

            return redirect(route('applications.index'));
        }

        if (ServiceInstance::where('application_id', $application->id)->whereNull('deleted_at')->count() > 0) {
            Flash::error(Lang::get('application.delete_app_instance_first'));

            return redirect(route('applications.index'));
        }

        $this->applicationRepository->delete($application->id);

        Flash::success(Lang::get('application.delete_confirm'));

        return redirect(route('applications.index'));
    }
}

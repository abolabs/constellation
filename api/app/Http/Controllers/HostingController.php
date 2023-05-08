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

use App\DataTables\HostingDataTable;
use App\Http\Requests\CreateHostingRequest;
use App\Http\Requests\UpdateHostingRequest;
use App\Models\Hosting;
use App\Models\ServiceInstance;
use App\Repositories\HostingRepository;
use Flash;
use Lang;
use Response;

class HostingController extends AppBaseController
{
    /** @var HostingRepository */
    private $hostingRepository;

    public function __construct(HostingRepository $hostingRepo)
    {
        $this->authorizeResource(Hosting::class);
        $this->hostingRepository = $hostingRepo;
    }

    /**
     * Display a listing of the Hosting.
     *
     * @return Response
     */
    public function index(HostingDataTable $hostingDataTable)
    {
        return $hostingDataTable->render('hostings.index');
    }

    /**
     * Show the form for creating a new Hosting.
     *
     * @return Response
     */
    public function create()
    {
        return view('hostings.create');
    }

    /**
     * Store a newly created Hosting in storage.
     *
     * @return Response
     */
    public function store(CreateHostingRequest $request)
    {
        $input = $request->all();

        $this->hostingRepository->create($input);

        Flash::success(Lang::get('hosting.store_confirm'));

        return redirect(route('hostings.index'));
    }

    /**
     * Display the specified Hosting.
     *
     * @return Response
     */
    public function show(Hosting $hosting)
    {
        if (empty($hosting)) {
            Flash::error(Lang::get('hosting.not_found'));

            return redirect(route('hostings.index'));
        }
        $instances = ServiceInstance::where('hosting_id', $hosting->id)->get();

        return view('hostings.show')->with('hosting', $hosting)->with('instances', $instances);
    }

    /**
     * Show the form for editing the specified Hosting.
     *
     * @return Response
     */
    public function edit(Hosting $hosting)
    {
        if (empty($hosting)) {
            Flash::error(Lang::get('hosting.not_found'));

            return redirect(route('hostings.index'));
        }

        return view('hostings.edit')->with('hosting', $hosting);
    }

    /**
     * Update the specified Hosting in storage.
     *
     * @return Response
     */
    public function update(Hosting $hosting, UpdateHostingRequest $request)
    {
        if (empty($hosting)) {
            Flash::error(Lang::get('hosting.not_found'));

            return redirect(route('hostings.index'));
        }

        $hosting = $this->hostingRepository->update($request->all(), $hosting->id);

        Flash::success(Lang::get('hosting.update_confirm'));

        return redirect(route('hostings.index'));
    }

    /**
     * Remove the specified Hosting from storage.
     *
     * @return Response
     */
    public function destroy(Hosting $hosting)
    {
        if (empty($hosting)) {
            Flash::error(Lang::get('hosting.not_found'));

            return redirect(route('hostings.index'));
        }

        $this->hostingRepository->delete($hosting->id);

        Flash::success(Lang::get('hosting.destroy_confirm'));

        return redirect(route('hostings.index'));
    }
}

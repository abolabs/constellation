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

use App\DataTables\EnvironnementDataTable;
use App\Http\Requests\CreateEnvironnementRequest;
use App\Http\Requests\UpdateEnvironnementRequest;
use App\Models\Environnement;
use App\Repositories\EnvironnementRepository;
use Flash;
use Lang;
use Response;

class EnvironnementController extends AppBaseController
{
    /** @var EnvironnementRepository */
    private $environnementRepository;

    public function __construct(EnvironnementRepository $environnementRepo)
    {
        $this->authorizeResource(Environnement::class);
        $this->environnementRepository = $environnementRepo;
    }

    /**
     * Display a listing of the Environnement.
     *
     * @return Response
     */
    public function index(EnvironnementDataTable $environnementDataTable)
    {
        return $environnementDataTable->render('environnements.index');
    }

    /**
     * Show the form for creating a new Environnement.
     *
     * @return Response
     */
    public function create()
    {
        return view('environnements.create');
    }

    /**
     * Store a newly created Environnement in storage.
     *
     * @return Response
     */
    public function store(CreateEnvironnementRequest $request)
    {
        $input = $request->all();

        $this->environnementRepository->create($input);

        Flash::success(Lang::get('environnement.saved_confirm'));

        return redirect(route('environnements.index'));
    }

    /**
     * Display the specified Environnement.
     *
     * @return Response
     */
    public function show(Environnement $environnement)
    {
        if (empty($environnement)) {
            Flash::error(Lang::get('environnement.not_found'));

            return redirect(route('environnements.index'));
        }

        return view('environnements.show')->with('environnement', $environnement);
    }

    /**
     * Show the form for editing the specified Environnement.
     *
     * @return Response
     */
    public function edit(Environnement $environnement)
    {
        if (empty($environnement)) {
            Flash::error(Lang::get('environnement.not_found'));

            return redirect(route('environnements.index'));
        }

        return view('environnements.edit')->with('environnement', $environnement);
    }

    /**
     * Update the specified Environnement in storage.
     *
     * @return Response
     */
    public function update(Environnement $environnement, UpdateEnvironnementRequest $request)
    {
        if (empty($environnement)) {
            Flash::error(Lang::get('environnement.not_found'));

            return redirect(route('environnements.index'));
        }

        $environnement = $this->environnementRepository->update($request->all(), $environnement->id);

        Flash::success(Lang::get('environnement.update_confirm'));

        return redirect(route('environnements.index'));
    }

    /**
     * Remove the specified Environnement from storage.
     *
     * @return Response
     */
    public function destroy(Environnement $environnement)
    {
        if (empty($environnement)) {
            Flash::error(Lang::get('environnement.not_found'));

            return redirect(route('environnements.index'));
        }

        $this->environnementRepository->delete($environnement->id);

        Flash::success(Lang::get('environnement.delete_confirm'));

        return redirect(route('environnements.index'));
    }
}

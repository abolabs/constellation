<?php

namespace App\Http\Controllers;

use App\DataTables\EnvironnementDataTable;
use App\Http\Requests\CreateEnvironnementRequest;
use App\Http\Requests\UpdateEnvironnementRequest;
use App\Models\Environnement;
use App\Repositories\EnvironnementRepository;
use Flash;
use Response;
use \Lang;

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
     * @param  EnvironnementDataTable  $environnementDataTable
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
     * @param  CreateEnvironnementRequest  $request
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
     * @param  Environnement  $environnement
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
     * @param  Environnement  $environnement
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
     * @param  Environnement  $environnement
     * @param  UpdateEnvironnementRequest  $request
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
     * @param  Environnement  $environnement
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

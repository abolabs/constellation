<?php

namespace App\Http\Controllers;

use App\DataTables\EnvironnementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEnvironnementRequest;
use App\Http\Requests\UpdateEnvironnementRequest;
use App\Repositories\EnvironnementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EnvironnementController extends AppBaseController
{
    /** @var  EnvironnementRepository */
    private $environnementRepository;

    public function __construct(EnvironnementRepository $environnementRepo)
    {
        $this->environnementRepository = $environnementRepo;
    }

    /**
     * Display a listing of the Environnement.
     *
     * @param EnvironnementDataTable $environnementDataTable
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
     * @param CreateEnvironnementRequest $request
     *
     * @return Response
     */
    public function store(CreateEnvironnementRequest $request)
    {
        $input = $request->all();

        $environnement = $this->environnementRepository->create($input);

        Flash::success('Environnement saved successfully.');

        return redirect(route('environnements.index'));
    }

    /**
     * Display the specified Environnement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            Flash::error('Environnement not found');

            return redirect(route('environnements.index'));
        }

        return view('environnements.show')->with('environnement', $environnement);
    }

    /**
     * Show the form for editing the specified Environnement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            Flash::error('Environnement not found');

            return redirect(route('environnements.index'));
        }

        return view('environnements.edit')->with('environnement', $environnement);
    }

    /**
     * Update the specified Environnement in storage.
     *
     * @param  int              $id
     * @param UpdateEnvironnementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEnvironnementRequest $request)
    {
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            Flash::error('Environnement not found');

            return redirect(route('environnements.index'));
        }

        $environnement = $this->environnementRepository->update($request->all(), $id);

        Flash::success('Environnement updated successfully.');

        return redirect(route('environnements.index'));
    }

    /**
     * Remove the specified Environnement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $environnement = $this->environnementRepository->find($id);

        if (empty($environnement)) {
            Flash::error('Environnement not found');

            return redirect(route('environnements.index'));
        }

        $this->environnementRepository->delete($id);

        Flash::success('Environnement deleted successfully.');

        return redirect(route('environnements.index'));
    }
}

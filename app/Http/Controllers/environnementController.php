<?php

namespace App\Http\Controllers;

use App\DataTables\environnementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateenvironnementRequest;
use App\Http\Requests\UpdateenvironnementRequest;
use App\Repositories\environnementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class environnementController extends AppBaseController
{
    /** @var  environnementRepository */
    private $environnementRepository;

    public function __construct(environnementRepository $environnementRepo)
    {
        $this->environnementRepository = $environnementRepo;
    }

    /**
     * Display a listing of the environnement.
     *
     * @param environnementDataTable $environnementDataTable
     * @return Response
     */
    public function index(environnementDataTable $environnementDataTable)
    {
        return $environnementDataTable->render('environnements.index');
    }

    /**
     * Show the form for creating a new environnement.
     *
     * @return Response
     */
    public function create()
    {
        return view('environnements.create');
    }

    /**
     * Store a newly created environnement in storage.
     *
     * @param CreateenvironnementRequest $request
     *
     * @return Response
     */
    public function store(CreateenvironnementRequest $request)
    {
        $input = $request->all();

        $environnement = $this->environnementRepository->create($input);

        Flash::success('Environnement saved successfully.');

        return redirect(route('environnements.index'));
    }

    /**
     * Display the specified environnement.
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
     * Show the form for editing the specified environnement.
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
     * Update the specified environnement in storage.
     *
     * @param  int              $id
     * @param UpdateenvironnementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateenvironnementRequest $request)
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
     * Remove the specified environnement from storage.
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

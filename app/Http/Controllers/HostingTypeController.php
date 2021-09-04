<?php

namespace App\Http\Controllers;

use App\DataTables\HostingTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateHostingTypeRequest;
use App\Http\Requests\UpdateHostingTypeRequest;
use App\Repositories\HostingTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class HostingTypeController extends AppBaseController
{
    /** @var  HostingTypeRepository */
    private $hostingTypeRepository;

    public function __construct(HostingTypeRepository $hostingTypeRepo)
    {
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * Display a listing of the HostingType.
     *
     * @param HostingTypeDataTable $hostingTypeDataTable
     * @return Response
     */
    public function index(HostingTypeDataTable $hostingTypeDataTable)
    {
        return $hostingTypeDataTable->render('hosting_types.index');
    }

    /**
     * Show the form for creating a new HostingType.
     *
     * @return Response
     */
    public function create()
    {
        return view('hosting_types.create');
    }

    /**
     * Store a newly created HostingType in storage.
     *
     * @param CreateHostingTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateHostingTypeRequest $request)
    {
        $input = $request->all();

        $hostingType = $this->hostingTypeRepository->create($input);

        Flash::success('Hosting Type saved successfully.');

        return redirect(route('hostingTypes.index'));
    }

    /**
     * Display the specified HostingType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.show')->with('hostingType', $hostingType);
    }

    /**
     * Show the form for editing the specified HostingType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.edit')->with('hostingType', $hostingType);
    }

    /**
     * Update the specified HostingType in storage.
     *
     * @param  int              $id
     * @param UpdateHostingTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHostingTypeRequest $request)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $hostingType = $this->hostingTypeRepository->update($request->all(), $id);

        Flash::success('Hosting Type updated successfully.');

        return redirect(route('hostingTypes.index'));
    }

    /**
     * Remove the specified HostingType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $this->hostingTypeRepository->delete($id);

        Flash::success('Hosting Type deleted successfully.');

        return redirect(route('hostingTypes.index'));
    }
}

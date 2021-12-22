<?php

namespace App\Http\Controllers;

use App\DataTables\HostingTypeDataTable;
use App\Http\Requests\CreateHostingTypeRequest;
use App\Http\Requests\UpdateHostingTypeRequest;
use App\Models\HostingType;
use App\Repositories\HostingTypeRepository;
use Flash;
use Response;

class HostingTypeController extends AppBaseController
{
    /** @var HostingTypeRepository */
    private $hostingTypeRepository;

    public function __construct(HostingTypeRepository $hostingTypeRepo)
    {
        $this->authorizeResource(HostingType::class, 'hostingType');
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * Display a listing of the HostingType.
     *
     * @param  HostingTypeDataTable  $hostingTypeDataTable
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
     * @param  CreateHostingTypeRequest  $request
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
     * @param  HostingType  $hostingType
     * @return Response
     */
    public function show(HostingType $hostingType)
    {
        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.show')->with('hostingType', $hostingType);
    }

    /**
     * Show the form for editing the specified HostingType.
     *
     * @param  HostingType  $hostingType
     * @return Response
     */
    public function edit(HostingType $hostingType)
    {
        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.edit')->with('hostingType', $hostingType);
    }

    /**
     * Update the specified HostingType in storage.
     *
     * @param  HostingType  $hostingType
     * @param  UpdateHostingTypeRequest  $request
     * @return Response
     */
    public function update(HostingType $hostingType, UpdateHostingTypeRequest $request)
    {
        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $hostingType = $this->hostingTypeRepository->update($request->all(), $hostingType->id);

        Flash::success('Hosting Type updated successfully.');

        return redirect(route('hostingTypes.index'));
    }

    /**
     * Remove the specified HostingType from storage.
     *
     * @param  HostingType  $hostingType
     * @return Response
     */
    public function destroy(HostingType $hostingType)
    {
        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $this->hostingTypeRepository->delete($hostingType->id);

        Flash::success('Hosting Type deleted successfully.');

        return redirect(route('hostingTypes.index'));
    }
}

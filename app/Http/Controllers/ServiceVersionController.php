<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceVersionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateServiceVersionRequest;
use App\Http\Requests\UpdateServiceVersionRequest;
use App\Repositories\ServiceVersionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ServiceVersionController extends AppBaseController
{
    /** @var  ServiceVersionRepository */
    private $serviceVersionRepository;

    public function __construct(ServiceVersionRepository $serviceVersionRepo)
    {
        $this->serviceVersionRepository = $serviceVersionRepo;
    }

    /**
     * Display a listing of the ServiceVersion.
     *
     * @param ServiceVersionDataTable $serviceVersionDataTable
     * @return Response
     */
    public function index(ServiceVersionDataTable $serviceVersionDataTable)
    {
        return $serviceVersionDataTable->render('service_versions.index');
    }

    /**
     * Show the form for creating a new ServiceVersion.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_versions.create');
    }

    /**
     * Store a newly created ServiceVersion in storage.
     *
     * @param CreateServiceVersionRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceVersionRequest $request)
    {
        $input = $request->all();

        $serviceVersion = $this->serviceVersionRepository->create($input);

        Flash::success('Service Version saved successfully.');

        return redirect(route('serviceVersions.index'));
    }

    /**
     * Display the specified ServiceVersion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        return view('service_versions.show')->with('serviceVersion', $serviceVersion);
    }

    /**
     * Show the form for editing the specified ServiceVersion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        return view('service_versions.edit')->with('serviceVersion', $serviceVersion);
    }

    /**
     * Update the specified ServiceVersion in storage.
     *
     * @param  int              $id
     * @param UpdateServiceVersionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceVersionRequest $request)
    {
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        $serviceVersion = $this->serviceVersionRepository->update($request->all(), $id);

        Flash::success('Service Version updated successfully.');

        return redirect(route('serviceVersions.index'));
    }

    /**
     * Remove the specified ServiceVersion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceVersion = $this->serviceVersionRepository->find($id);

        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        $this->serviceVersionRepository->delete($id);

        Flash::success('Service Version deleted successfully.');

        return redirect(route('serviceVersions.index'));
    }
}

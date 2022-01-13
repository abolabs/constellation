<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceVersionDataTable;
use App\Http\Requests\CreateServiceVersionRequest;
use App\Http\Requests\UpdateServiceVersionRequest;
use App\Models\ServiceInstance;
use App\Models\ServiceVersion;
use App\Repositories\ServiceVersionRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class ServiceVersionController extends AppBaseController
{
    /** @var ServiceVersionRepository */
    private $serviceVersionRepository;

    public function __construct(ServiceVersionRepository $serviceVersionRepo)
    {
        $this->authorizeResource(ServiceVersion::class, 'serviceVersion');
        $this->serviceVersionRepository = $serviceVersionRepo;
    }

    /**
     * Display a listing of the ServiceVersion.
     *
     * @param  ServiceVersionDataTable  $serviceVersionDataTable
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
     * @param  CreateServiceVersionRequest  $request
     * @return Response
     */
    public function store(CreateServiceVersionRequest $request)
    {
        $input = $request->all();

        $serviceVersion = $this->serviceVersionRepository->create($input);
        if (empty($serviceVersion)) {
            Flash::error('Error during saving the new version');
        } else {
            Flash::success('Service Version saved successfully.');
        }

        if (! empty($input['redirect_to_service'])) {
            return back()->withInput();
        }

        return redirect(route('serviceVersions.index'));
    }

    /**
     * Display the specified ServiceVersion.
     *
     * @param  ServiceVersion  $serviceVersion
     * @return Response
     */
    public function show(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        return view('service_versions.show')->with('serviceVersion', $serviceVersion);
    }

    /**
     * Show the form for editing the specified ServiceVersion.
     *
     * @param  ServiceVersion  $serviceVersion
     * @return Response
     */
    public function edit(ServiceVersion $serviceVersion)
    {
        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        return view('service_versions.edit')->with('serviceVersion', $serviceVersion);
    }

    /**
     * Update the specified ServiceVersion in storage.
     *
     * @param  ServiceVersion  $serviceVersion
     * @param  UpdateServiceVersionRequest  $request
     * @return Response
     */
    public function update(ServiceVersion $serviceVersion, UpdateServiceVersionRequest $request)
    {
        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }

        $serviceVersion = $this->serviceVersionRepository->update($request->all(), $serviceVersion->id);

        Flash::success('Service Version updated successfully.');

        return redirect(route('serviceVersions.index'));
    }

    /**
     * Remove the specified ServiceVersion from storage.
     *
     * @param  ServiceVersion  $serviceVersion
     * @return Response
     */
    public function destroy(ServiceVersion $serviceVersion, Request $request)
    {
        $input = $request->all();

        if (empty($serviceVersion)) {
            Flash::error('Service Version not found');

            return redirect(route('serviceVersions.index'));
        }
        if (ServiceInstance::where('service_version_id', $serviceVersion->id)->count() > 0) {
            Flash::error('Service version is currently used, cannot delete it.');

            return redirect(route('serviceVersions.index'));
        }

        $this->serviceVersionRepository->delete($serviceVersion->id);

        Flash::success('Service Version deleted successfully.');

        if (! empty($input['redirect_to_version'])) {
            return redirect(route('services.show', $serviceVersion->service->id));
        }

        return redirect(route('serviceVersions.index'));
    }
}

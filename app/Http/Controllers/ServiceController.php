<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceDataTable;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceVersion;
use App\Repositories\ServiceRepository;
use Flash;
use Response;

class ServiceController extends AppBaseController
{
    /** @var ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->authorizeResource(Service::class);
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Service.
     *
     * @param  ServiceDataTable  $serviceDataTable
     * @return Response
     */
    public function index(ServiceDataTable $serviceDataTable)
    {
        return $serviceDataTable->render('services.index');
    }

    /**
     * Show the form for creating a new Service.
     *
     * @return Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param  CreateServiceRequest  $request
     * @return Response
     */
    public function store(CreateServiceRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        Flash::success('Service saved successfully.');

        return redirect(route('services.index'));
    }

    /**
     * Display the specified Service.
     *
     * @param  Service  $service
     * @return Response
     */
    public function show(Service $service)
    {
        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }
        $service->load('versions', 'versions.instances.application');

        $serviceByApplication = [];
        foreach ($service->versions as $version) {
            $serviceByApplication[$version->id] = [];
            foreach ($version->instances as $instance) {
                if (! isset($serviceByApplication[$version->id][$instance->application->id])) {
                    $serviceByApplication[$version->id][$instance->application->id] = [
                        'name' => $instance->application->name,
                        'total' => 0,
                    ];
                }
                $serviceByApplication[$version->id][$instance->application->id]['total']++;
            }
        }

        return view('services.show')->with('service', $service)->with('serviceByApplication', $serviceByApplication);
    }

    /**
     * Show the form for editing the specified Service.
     *
     * @param  Service  $service
     * @return Response
     */
    public function edit(Service $service)
    {
        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        return view('services.edit')->with('service', $service);
    }

    /**
     * Update the specified Service in storage.
     *
     * @param  Service  $service
     * @param  UpdateServiceRequest  $request
     * @return Response
     */
    public function update(Service $service, UpdateServiceRequest $request)
    {
        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        $service = $this->serviceRepository->update($request->all(), $service->id);

        Flash::success('Service updated successfully.');

        return redirect(route('services.index'));
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param  Service  $service
     * @return Response
     */
    public function destroy(Service $service)
    {
        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('services.index'));
        }

        if (ServiceVersion::where('service_id', $service->id)->count() > 0) {
            Flash::error('Service has version(s), delete them firstly.');

            return redirect(route('services.index'));
        }

        $this->serviceRepository->delete($service->id);

        Flash::success('Service deleted successfully.');

        return redirect(route('services.index'));
    }
}

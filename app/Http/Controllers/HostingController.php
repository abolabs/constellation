<?php

namespace App\Http\Controllers;

use App\DataTables\HostingDataTable;
use App\Http\Requests\CreateHostingRequest;
use App\Http\Requests\UpdateHostingRequest;
use App\Models\Hosting;
use App\Models\ServiceInstance;
use App\Repositories\HostingRepository;
use Flash;
use Response;
use \Lang;

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
     * @param  HostingDataTable  $hostingDataTable
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
     * @param  CreateHostingRequest  $request
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
     * @param  Hosting  $hosting
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
     * @param  Hosting  $hosting
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
     * @param  Hosting  $hosting
     * @param  UpdateHostingRequest  $request
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
     * @param  Hosting  $hosting
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

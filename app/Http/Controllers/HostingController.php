<?php

namespace App\Http\Controllers;

use App\DataTables\HostingDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateHostingRequest;
use App\Http\Requests\UpdateHostingRequest;
use App\Repositories\HostingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class HostingController extends AppBaseController
{
    /** @var  HostingRepository */
    private $hostingRepository;

    public function __construct(HostingRepository $hostingRepo)
    {
        $this->hostingRepository = $hostingRepo;
    }

    /**
     * Display a listing of the Hosting.
     *
     * @param HostingDataTable $hostingDataTable
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
     * @param CreateHostingRequest $request
     *
     * @return Response
     */
    public function store(CreateHostingRequest $request)
    {
        $input = $request->all();

        $hosting = $this->hostingRepository->create($input);

        Flash::success('Hosting saved successfully.');

        return redirect(route('hostings.index'));
    }

    /**
     * Display the specified Hosting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            Flash::error('Hosting not found');

            return redirect(route('hostings.index'));
        }

        return view('hostings.show')->with('hosting', $hosting);
    }

    /**
     * Show the form for editing the specified Hosting.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            Flash::error('Hosting not found');

            return redirect(route('hostings.index'));
        }

        return view('hostings.edit')->with('hosting', $hosting);
    }

    /**
     * Update the specified Hosting in storage.
     *
     * @param  int              $id
     * @param UpdateHostingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHostingRequest $request)
    {
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            Flash::error('Hosting not found');

            return redirect(route('hostings.index'));
        }

        $hosting = $this->hostingRepository->update($request->all(), $id);

        Flash::success('Hosting updated successfully.');

        return redirect(route('hostings.index'));
    }

    /**
     * Remove the specified Hosting from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hosting = $this->hostingRepository->find($id);

        if (empty($hosting)) {
            Flash::error('Hosting not found');

            return redirect(route('hostings.index'));
        }

        $this->hostingRepository->delete($id);

        Flash::success('Hosting deleted successfully.');

        return redirect(route('hostings.index'));
    }
}

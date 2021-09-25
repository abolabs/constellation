<?php

namespace App\Http\Controllers;

use App\DataTables\AppInstanceDataTable;
use App\Http\Requests\CreateAppInstanceRequest;
use App\Http\Requests\UpdateAppInstanceRequest;
use App\Repositories\AppInstanceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AppInstanceController extends AppBaseController
{
    /** @var  AppInstanceRepository */
    private $appInstanceRepository;

    public function __construct(AppInstanceRepository $appInstanceRepo)
    {
        $this->appInstanceRepository = $appInstanceRepo;
    }

    /**
     * Display a listing of the AppInstance.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(AppInstanceDataTable $appInstanceDataTable)
    {
        return $appInstanceDataTable->render('app_instances.index');
    }

    /**
     * Show the form for creating a new AppInstance.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_instances.create');
    }

    /**
     * Store a newly created AppInstance in storage.
     *
     * @param CreateAppInstanceRequest $request
     *
     * @return Response
     */
    public function store(CreateAppInstanceRequest $request)
    {
        $input = $request->all();

        $appInstance = $this->appInstanceRepository->create($input);

        Flash::success('App Instance saved successfully.');

        return redirect(route('appInstances.index'));
    }

    /**
     * Display the specified AppInstance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            Flash::error('App Instance not found');

            return redirect(route('appInstances.index'));
        }

        return view('app_instances.show')->with('appInstance', $appInstance);
    }

    /**
     * Show the form for editing the specified AppInstance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            Flash::error('App Instance not found');

            return redirect(route('appInstances.index'));
        }

        return view('app_instances.edit')->with('appInstance', $appInstance);
    }

    /**
     * Update the specified AppInstance in storage.
     *
     * @param int $id
     * @param UpdateAppInstanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppInstanceRequest $request)
    {
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            Flash::error('App Instance not found');

            return redirect(route('appInstances.index'));
        }

        $appInstance = $this->appInstanceRepository->update($request->all(), $id);

        Flash::success('App Instance updated successfully.');

        return redirect(route('appInstances.index'));
    }

    /**
     * Remove the specified AppInstance from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appInstance = $this->appInstanceRepository->find($id);

        if (empty($appInstance)) {
            Flash::error('App Instance not found');

            return redirect(route('appInstances.index'));
        }

        $this->appInstanceRepository->delete($id);

        Flash::success('App Instance deleted successfully.');

        return redirect(route('appInstances.index'));
    }
}

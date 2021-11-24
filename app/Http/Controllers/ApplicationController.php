<?php

namespace App\Http\Controllers;

use App\DataTables\ApplicationDataTable;
use App\Http\Requests\CreateApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Repositories\ApplicationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\ServiceInstance;
use App\Models\Environnement;
use Response;

class ApplicationController extends AppBaseController
{
    /** @var  ApplicationRepository */
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepo)
    {
        $this->applicationRepository = $applicationRepo;
    }

    /**
     * Display a listing of the Application.
     *
     * @param ApplicationDataTable $applicationDataTable
     * @return Response
     */
    public function index(ApplicationDataTable $applicationDataTable)
    {
        return $applicationDataTable->render('applications.index');
    }

    /**
     * Show the form for creating a new Application.
     *
     * @return Response
     */
    public function create()
    {
        return view('applications.create');
    }

    /**
     * Store a newly created Application in storage.
     *
     * @param CreateApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateApplicationRequest $request)
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        Flash::success('Application saved successfully.');

        return redirect(route('applications.show', $application->id));
    }

    /**
     * Display the specified Application.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $application = $this->applicationRepository->find($id);

        $serviceInstances = ServiceInstance::where("application_id",$id)->with(['serviceVersion','serviceVersion.service','environnement'])->orderBy('environnement_id')->get();

        $countByEnv = Environnement::withCount('serviceInstances')->with('serviceInstances', function($query) use ($id) {
                $query->where('application_id', $id);
            })->get()->keyBy('id')->toArray();


        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('applications.index'));
        }

        return view('applications.show')->with('application', $application)
                    ->with('serviceInstances',$serviceInstances)
                    ->with('countByEnv',$countByEnv);
    }

    /**
     * Show the form for editing the specified Application.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('applications.index'));
        }

        return view('applications.edit')->with('application', $application);
    }

    /**
     * Update the specified Application in storage.
     *
     * @param  int              $id
     * @param UpdateApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApplicationRequest $request)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('applications.index'));
        }

        $application = $this->applicationRepository->update($request->all(), $id);

        Flash::success('Application updated successfully.');

        return redirect(route('applications.index'));
    }

    /**
     * Remove the specified Application from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('applications.index'));
        }

        if(ServiceInstance::where('application_id',$id)->whereNull('deleted_at')->count()>0){
            Flash::error('Impossible de supprimer l\'application, des instances de services sont attachées à l\'application.');

            return redirect(route('applications.index'));
        }

        $this->applicationRepository->delete($id);

        Flash::success('Application deleted successfully.');

        return redirect(route('applications.index'));
    }
}

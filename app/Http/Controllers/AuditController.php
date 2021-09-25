<?php

namespace App\Http\Controllers;

use App\DataTables\AuditDataTable;
use App\Http\Requests\CreateAuditRequest;
use App\Http\Requests\UpdateAuditRequest;
use App\Repositories\AuditRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AuditController extends AppBaseController
{
    /** @var  AuditRepository */
    private $auditRepository;

    public function __construct(AuditRepository $auditRepo)
    {
        $this->auditRepository = $auditRepo;
    }

    /**
     * Display a listing of the Audit.
     *
     * @param AuditDataTable $auditDataTable
     * @return Response
     */
    public function index(AuditDataTable $auditDataTable)
    {
        return $auditDataTable->render('audits.index');
    }

    /**
     * Show the form for creating a new Audit.
     *
     * @return Response
     */
    public function create()
    {
        return view('audits.create');
    }

    /**
     * Store a newly created Audit in storage.
     *
     * @param CreateAuditRequest $request
     *
     * @return Response
     */
    public function store(CreateAuditRequest $request)
    {
        $input = $request->all();

        $audit = $this->auditRepository->create($input);

        Flash::success('Audit saved successfully.');

        return redirect(route('audits.index'));
    }

    /**
     * Display the specified Audit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $audit = $this->auditRepository->find($id);

        if (empty($audit)) {
            Flash::error('Audit not found');

            return redirect(route('audits.index'));
        }

        return view('audits.show')->with('audit', $audit);
    }

    /**
     * Show the form for editing the specified Audit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $audit = $this->auditRepository->find($id);

        if (empty($audit)) {
            Flash::error('Audit not found');

            return redirect(route('audits.index'));
        }

        return view('audits.edit')->with('audit', $audit);
    }

    /**
     * Update the specified Audit in storage.
     *
     * @param  int              $id
     * @param UpdateAuditRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuditRequest $request)
    {
        $audit = $this->auditRepository->find($id);

        if (empty($audit)) {
            Flash::error('Audit not found');

            return redirect(route('audits.index'));
        }

        $audit = $this->auditRepository->update($request->all(), $id);

        Flash::success('Audit updated successfully.');

        return redirect(route('audits.index'));
    }

    /**
     * Remove the specified Audit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $audit = $this->auditRepository->find($id);

        if (empty($audit)) {
            Flash::error('Audit not found');

            return redirect(route('audits.index'));
        }

        $this->auditRepository->delete($id);

        Flash::success('Audit deleted successfully.');

        return redirect(route('audits.index'));
    }
}

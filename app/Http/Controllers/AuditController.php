<?php

namespace App\Http\Controllers;

use App\DataTables\AuditDataTable;
use App\Http\Requests\CreateAuditRequest;
use App\Http\Requests\UpdateAuditRequest;
use App\Repositories\AuditRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Audit;
use Response;

class AuditController extends AppBaseController
{
    /** @var  AuditRepository */
    private $auditRepository;

    public function __construct(AuditRepository $auditRepo)
    {
        $this->authorizeResource(Audit::class);
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
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
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
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
    }

    /**
     * Display the specified Audit.
     *
     * @param  Audit $audit
     *
     * @return Response
     */
    public function show(Audit $audit)
    {
        if (empty($audit)) {
            Flash::error('Audit not found');

            return redirect(route('audits.index'));
        }

        return view('audits.show')->with('audit', $audit);
    }

    /**
     * Show the form for editing the specified Audit.
     *
     * @param  Audit $audit
     *
     * @return Response
     */
    public function edit(Audit $audit)
    {
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
    }

    /**
     * Update the specified Audit in storage.
     *
     * @param  Audit $audit
     * @param UpdateAuditRequest $request
     *
     * @return Response
     */
    public function update(Audit $audit, UpdateAuditRequest $request)
    {
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
    }

    /**
     * Remove the specified Audit from storage.
     *
     * @param  Audit $audit
     *
     * @return Response
     */
    public function destroy(Audit $audit)
    {
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
    }
}

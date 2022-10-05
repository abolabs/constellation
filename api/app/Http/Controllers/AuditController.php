<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Http\Controllers;

use App\DataTables\AuditDataTable;
use App\Http\Requests\CreateAuditRequest;
use App\Http\Requests\UpdateAuditRequest;
use App\Models\Audit;
use App\Repositories\AuditRepository;
use Flash;
use Response;

class AuditController extends AppBaseController
{
    /** @var AuditRepository */
    private $auditRepository;

    public function __construct(AuditRepository $auditRepo)
    {
        $this->authorizeResource(Audit::class);
        $this->auditRepository = $auditRepo;
    }

    /**
     * Display a listing of the Audit.
     *
     * @param  AuditDataTable  $auditDataTable
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
     * @param  CreateAuditRequest  $request
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
     * @param  Audit  $audit
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
     * @param  Audit  $audit
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
     * @param  Audit  $audit
     * @param  UpdateAuditRequest  $request
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
     * @param  Audit  $audit
     * @return Response
     */
    public function destroy(Audit $audit)
    {
        Flash::error(\Lang::get('common.not_implemented'));

        return redirect(route('audits.index'));
    }
}

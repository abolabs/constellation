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

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AuditResource;
use App\Models\Audit;
use App\Repositories\AuditRepository;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpFoundation\Response as HttpCode;

/**
 * Class AuditAPIController.
 */
class AuditAPIController extends AppBaseController
{
    /** @var AuditRepository */
    private $auditRepository;

    public function __construct(AuditRepository $auditRepository)
    {
        $this->auditRepository = $auditRepository;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/Audits",
     *      summary="Get a listing of the Audits.",
     *      tags={"Audits"},
     *      description="Get all Audits",
     *      produces={"application/json"},
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *
     *                  @SWG\Items(ref="#/definitions/Audit")
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $audits = $this->auditRepository->apiAll(
            $request->except(['perPage', 'page', 'sort']),
            $request->perPage,
            $request->page,
            $request->sort
        );

        return $this->sendResponse(AuditResource::collection($audits), 'Audits retrieved successfully', $audits->total());
    }

    public function store()
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @param  int  $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/Audit/{id}",
     *      summary="Display the specified Audit",
     *      tags={"Audit"},
     *      description="Get Audit",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Audit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @SWG\Schema(
     *              type="object",
     *
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Audit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Audit $audit */
        $audit = $this->auditRepository->find($id);

        if (empty($audit)) {
            return $this->sendError('Audit not found');
        }

        return $this->sendResponse(new AuditResource($audit), 'Audit retrieved successfully');
    }

    public function update()
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    public function destroy()
    {
        return $this->sendError('Not implemented', HttpCode::HTTP_NOT_IMPLEMENTED);
    }
}

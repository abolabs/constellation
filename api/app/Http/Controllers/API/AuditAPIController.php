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
use App\Http\OAT\Responses\SuccessGetListResponse;
use App\Http\OAT\Responses\NotFoundItemResponse;
use App\Http\OAT\Responses\SuccessGetViewResponse;
use App\Http\Resources\AuditResource;
use App\Models\Audit;
use App\Repositories\AuditRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpCode;
use OpenApi\Attributes as OAT;

/**
 * Class AuditAPIController.
 */
class AuditAPIController extends AppBaseController
{
    /** @var AuditRepository */
    private $auditRepository;

    public function __construct(AuditRepository $auditRepository)
    {
        $this->authorizeResource(Audit::class);
        $this->auditRepository = $auditRepository;
    }

    /**
     * Index
     */
    #[OAT\Get(
        path: '/v1/audits',
        operationId: 'getAudits',
        summary: "Get a listing of the audits.",
        description: "Get all audits",
        tags: ["Audit"],
        parameters: [
            new OAT\Parameter(ref: '#/components/parameters/base-filter-per-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-page'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-sort'),
            new OAT\Parameter(ref: '#/components/parameters/base-filter-q'),
            new OAT\Parameter(
                name: "filter[user_id]",
                description: "Filter by user id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
        ],
        responses: [
            new SuccessGetListResponse(
                description: 'Audits list',
                resourceSchema: '#/components/schemas/resource-audit'
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
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
     * View
     */
    #[OAT\Get(
        path: '/v1/audits/{id}',
        operationId: 'showAudit',
        summary: "Display the specified audit.",
        description: "Get audit",
        tags: ["Audit"],
        parameters: [
            new OAT\PathParameter(
                name: "id",
                required: true,
                description: "id of the audit",
                schema: new OAT\Schema(
                    type: "integer"
                )
            ),
        ],
        responses: [
            new SuccessGetViewResponse(
                description: 'Audit detail',
                resourceSchema: '#/components/schemas/resource-audit'
            ),
            new NotFoundItemResponse()
        ]
    )]
    public function show(Audit $audit): JsonResponse
    {
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

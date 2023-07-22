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

use App\Http\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Response;
use OpenApi\Attributes as OAT;

#[OAT\Info(
    title: "Constellation APIs",
    version: "2.0"
)]
#[OAT\Server(
    url: "http://localhost:8080/api",
    description: 'The local environment.'
)]
#[OAT\OpenApi(
    openapi: '3.1.0',
    security: [[
        'bearerAuth' => []
    ]]
)]
#[OAT\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    description: 'Basic Auth'
)]
#[OAT\License(
    name: 'GNU AFFERO GENERAL PUBLIC LICENSE',
    url: 'https://www.gnu.org/licenses/agpl-3.0.en.html',
)]
/*
* This class should be parent class for other API controllers
*/
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, ?int $total = null): JsonResponse
    {
        return Response::json(ResponseUtil::makeResponse($message, $result, $total));
    }

    public function sendError($error, $code = 404): JsonResponse
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message): JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="localhost:8080",
 *   basePath="/api",
 *   @SWG\Info(
 *     title="Constellation APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, ?int $total=null)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result, $total));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
}

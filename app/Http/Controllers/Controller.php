<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * sendError
     *
     * @param  $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, int $code = 404): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $error
        ], $code);
    }

    /**
     * sendSuccess
     *
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendSuccess($message, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ], $code);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    static function asJson($success, $error_key = null, $error_message = null)
    {
        return response()->json([
            'data' => $success,
            'error' => [
                'key' => $error_key,
                'message' => $error_message
            ]
        ], $success == null ? 500 : 200);
    }
}

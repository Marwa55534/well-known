<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function formatResponse($data = null, $message = '', $status = true, $code = 200)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

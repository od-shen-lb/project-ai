<?php

namespace App\Http\MiscControllers;

use Illuminate\Http\JsonResponse;

class HealthCheckController
{
    public function index(): JsonResponse
    {
        return response()->json(['status' => 'ok'], 200);
    }
}

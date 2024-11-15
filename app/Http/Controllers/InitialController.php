<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class InitialController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct() {}

    public function jsonResponse($statusCode, $message, $data = null): JsonResponse
    {
        return apiResponse($statusCode, $message, $data);
    }
}

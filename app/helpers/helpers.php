<?php

use Illuminate\Http\JsonResponse;

function apiResponse($statusCode, $message, $data): JsonResponse
{
    return response()->json([
        'status' => $statusCode,
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}

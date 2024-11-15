<?php

namespace App\Services;

class BaseService
{
    public function responseService($status, $message, $data = null): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}

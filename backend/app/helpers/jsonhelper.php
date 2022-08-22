<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('returnMessage')) {
    /**
     * API返却用関数
     * @param boolean $status
     * @param string $message
     * @param array|null $data
     * @param integer|null $statusCode
     * @return JsonResponse
     */
    function returnMessage(bool $status, string $message, ?array $data = [], ?int $statusCode = 200): JsonResponse
    {
        response()->json(
            [
                'status' => $status ? 'Success' : 'Error',
                'message' => $message,
                'data' => $data
            ],
            $statusCode
        )->send();
        exit();
    }
}


<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    protected function successResponse($data, $message = null, $code = 200): JsonResponse
    {
        if ($data instanceof LengthAwarePaginator) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data->items(),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ]
            ], $code);
        }
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
} 
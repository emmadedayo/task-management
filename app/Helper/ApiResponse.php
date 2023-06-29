<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = [], $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function successTwo($message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'success' => true,
            'message' => $message,
        ], $statusCode);
    }

    public static function error($message = 'Error', $statusCode = 500)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}

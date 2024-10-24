<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sendResponse($message = 'Done', $data = null, $statusCode = 200) {
        $response = [
            'status' => 'success',
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    public function sendError($message = 'Internal Server Error', $statusCode = 500) {
        $response = [
            'status' => 'failed',
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }
}
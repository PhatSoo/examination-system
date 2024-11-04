<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

abstract class Controller
{
    public function sendResponse($message = 'Done', $data = null, $statusCode = 200) {
        $response = [
            'status' => 'success',
            'statusCode' => $statusCode,
            'message' => $message,
            'result' => $data,
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

    public function handleException(\Throwable $th) {
        Log::error("An error occurred: " . $th->getMessage() . " on file::" . $th->getFile() ." ...at line::" . $th->getLine());
        return $this->sendError();
    }
}

<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponse
{
    public function sendResponse($data = [], $message = '',  $code = Response::HTTP_OK): JsonResponse
    {
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'code' => $code
            ], $code);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => $code
        ], $code);
    }

    public function sendError($message = '', $errors = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
                'code' => $code
            ], $code);
        }

        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $code
        ], $code);
    }
}

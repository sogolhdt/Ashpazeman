<?php

namespace App\Traits\Responses;

use Illuminate\Http\JsonResponse;

trait FailedResponseTrait
{
    protected function failedResponse($message = 'خطایی رخ داده است!', $statusCode = 400, $errors = null, $data = null): JsonResponse
    {
        $responseData = [
            'meta' => [
                'status' => false,
                'message' => $message,
            ],
        ];

        if ($errors !== null) {
            $responseData['meta']['errors'] = $errors;
        }
        if ($data !== null) {
            $responseData['meta']['data'] = $data;
        }

        return response()->json($responseData, $statusCode);
    }
}

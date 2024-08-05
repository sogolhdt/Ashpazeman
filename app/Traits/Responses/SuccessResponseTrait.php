<?php

namespace App\Traits\Responses;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;

trait SuccessResponseTrait
{
    protected function successResponse($data = null, $message = 'عملیات با موفقیت انجام شد.', $statusCode = 200): JsonResponse
    {
        $responseData = [
            'meta' => [
                'status' => true,
                'message' => $message,
            ],
        ];

        if ($data !== null) {
            $responseData['data'] = $data;
        }

        return response()->json($responseData, $statusCode);
    }

    protected function tokenResponse($token,$user=null, $message = "عملیات با موفقیت انجام شد.")
    {
        return response()->json([
            'data'=>[
                'token'=>$token,
                'user'=> $user? new UserResource($user) : null,
            ],
            'meta' => [
                'status' => true,
                'message' => $message
            ]

        ], 200);
    }
}

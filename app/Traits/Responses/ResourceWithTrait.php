<?php


namespace App\Traits\Responses;


trait ResourceWithTrait
{

    public function with($request)
    {

        return [

            'meta' => [
                'status' => true,
                'message' => 'عملیات با موفقیت انجام شد.'
            ]
        ];
    }
}

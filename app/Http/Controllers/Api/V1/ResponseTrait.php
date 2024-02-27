<?php

namespace App\Http\Controllers\Api\V1;

trait ResponseTrait
{
    public function apiResponse(Object $collection = null, string $message = null, int $status = null)
    {
        $array = [
            'message' => $message,
            'status' => $status,
            'data' => $collection,
        ];

        return response()->json($array, $status);
    }
}

<?php

namespace App\Http\Traits;

trait RestApiResponseTrait
{
    protected function respondCreated($message = null)
    {
        return response()->json([
            'message' => $message ?? 'Created successfully.'
        ], 201);
    }
}

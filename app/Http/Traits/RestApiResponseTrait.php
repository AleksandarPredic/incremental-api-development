<?php

namespace App\Http\Traits;

trait RestApiResponseTrait
{
    protected function respondCreated($id)
    {
        return response()->json([
            'data' => [
                'id' => $id
            ],
        ], 201);
    }
}

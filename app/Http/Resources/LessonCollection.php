<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LessonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // This collection is automatically using LessonResource.php
        return [
            'data' => $this->collection,
            'metaData' => [
                'link' => 'link-value',
            ],
        ];
    }
}

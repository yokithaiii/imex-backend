<?php

namespace App\Http\Resources\Tender;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'type' => $this->type
        ];
    }
}

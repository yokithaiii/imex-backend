<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderBidResource extends JsonResource
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
            'price' => $this->price,
            'date' => $this->date,
            'company_id' => $this->company_id
        ];
    }
}

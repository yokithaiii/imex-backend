<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\Company\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderParticipatedResource extends JsonResource
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
            'tender_number' => $this->tender_number,
            'title' => $this->title,
            'unit_quantity' => $this->unit_quantity,
            'unit_measure' => $this->unit_measure,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_price' => $this->start_price,
            'max_price' => $this->max_price,
            'status' => $this->status,
            'company' => CompanyResource::make($this->company),
        ];
    }
}

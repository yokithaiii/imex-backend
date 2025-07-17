<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderResource extends JsonResource
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
            'description' => $this->description,
            'item' => [
                'name' => $this->item_name,
                'unit_of_measure' => $this->unit_of_measure,
                'quantity' => $this->quantity,
                'price_per_unit' => $this->price_per_unit,
            ],
            'payment' => $this->payment->title,
            'total_amount' => $this->total_amount,
            'delivery_place' => $this->delivery_place,
            'notes' => $this->notes,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'submission_deadline' => $this->submission_deadline,
            'auction_date' => $this->auction_date,
            'user' => UserResource::make($this->user),
            'category' => TenderCategoryResource::make($this->category),
        ];
    }
}

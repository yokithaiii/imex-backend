<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Tender\TenderBidResource;
use App\Http\Resources\Tender\TenderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBigResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'phone' => $this->phone,
            'have_subscription' => $this->subscription->is_active,
            'subscription' => $this->subscription,
            'tariff' => $this->tariff
//            'tenders' => TenderResource::collection($this->tenders),
//            'bids' => TenderBidResource::collection($this->bids)
        ];
    }
}

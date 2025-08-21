<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'type' => $this->type,
            'inn' => $this->inn,
            'kpp' => $this->kpp,
            'ogrn' => $this->ogrn,
            'okved' => $this->okved,
            'names' => [
                'full' => $this->name_full,
                'short' => $this->name_short,
            ],
            'management' => [
                'name' => $this->management_name,
                'post' => $this->management_post
            ],
            'address' => [
                'country' => $this->city->region->country->name,
                'region' => $this->city->region->name,
                'city' => $this->city->name,
                'postal_code' => $this->postal_code,
                'full_address' => $this->address
            ],
            'contacts' => [
                'email' => $this->email_corporate,
                'phone' => $this->phone_corporate,
            ],
            'statuses' => [
                'is_verified' => $this->is_verified,
                'is_deleted' => false, // need to add
                'is_banned' => false, // need to add
            ],
            'user' => UserResource::make($this->user)
        ];
    }
}

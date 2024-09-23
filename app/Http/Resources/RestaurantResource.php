<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'city_id' => $this->city_id,
            'admin_id' => $this->admin_id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'address' => $this->address,
            'role' => $this->role,
            'status' => $this->status,
            'token' => $this->token,
            'shop_info' => $this->shop_info,
            'cover_photo' => $this->cover_photo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'rating_count' => $this->reviews ? $this->reviews->count() : 0, // Check for null
            'avg_rating' => $this->reviews ? $this->reviews->avg('rating') : 0, // Check for null

        ];
    }
}

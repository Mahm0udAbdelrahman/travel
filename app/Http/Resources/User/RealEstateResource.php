<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RealEstateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'category_real_estate' => $this->categoryRealEstate->name[app()->getLocale()] ?? $this->categoryRealEstate->name['en'] ?? null,
            'image' => $this->image,
            'name' => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'description' => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price' => $this->price,
            'city' => $this->city->name[app()->getLocale()] ?? $this->city->name['en'] ?? null,

        ];
    }
}

<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'image'          => $this->image,
            'name'           => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'start_date'     => $this->start_date,
            'end_date'       => $this->end_date,
            'description'    => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price'          => $this->price,
            'excursions_count' => $this->excursions()->count(),
            'excursions'       => ExcursionResource::collection($this->whenLoaded('excursions')),

        ];
    }
}

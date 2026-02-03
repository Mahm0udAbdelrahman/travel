<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'favoritable_id'          => $this->favoritable->id,
            'favoritable_type'        => $this->favoritable_type,
            'favoritable_name'        => $this->favoritable->name[app()->getLocale()],
            'favoritable_image'       => $this->favoritable->image,
            'favoritable_price'       => $this->favoritable->price ?? 0,
            'favoritable_description' => $this->favoritable->description[app()->getLocale()],
            'is_favorite'             => $this->is_favorite,

        ];
    }
}

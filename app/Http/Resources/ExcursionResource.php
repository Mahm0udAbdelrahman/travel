<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExcursionResource extends JsonResource
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
            'category_excursion' => $this->categoryExcursion->name[app()->getLocale()] ?? $this->categoryExcursion->name['en'] ?? null,
            'image' => $this->image,
            'name' => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'date' => $this->date,
            'description' => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price' => $this->price,
            'hours' => $this->hours,
            'city' => $this->city->name[app()->getLocale()] ?? $this->city->name['en'] ?? null,
        ];
    }
}

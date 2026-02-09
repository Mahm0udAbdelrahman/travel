<?php

namespace App\Http\Resources\User;

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
            'id'                        => $this->id,
            'category_excursion_id'     => $this->category_excursion_id,
            'category_excursion'        => $this->categoryExcursion->name[app()->getLocale()] ?? $this->categoryExcursion->name['en'] ?? null,
            'sub_category_excursion_id' => $this->sub_category_excursion_id,
            'sub_category_excursion'    => $this->subcategoryExcursion->name[app()->getLocale()] ?? $this->subcategoryExcursion->name['en'] ?? null,
            'image'                     => $this->image,
            'name'                      => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'date'                      => $this->date,
            'description'               => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price'                     => $this->price,
            'hours'                     => $this->hours,
            'city'                      => $this->city->name[app()->getLocale()] ?? $this->city->name['en'] ?? null,

                    'days' => $this->whenLoaded('days', function () {
            return $this->days->map(function ($day) {
                return [
                    'id'   => $day->id,
                    'day'  => $day->day,
                    'times' => $day->times->map(function ($time) {
                        return [
                            'id'        => $time->id,
                            'from_time' => $time->from_time,
                            'to_time'   => $time->to_time,
                        ];
                    })->values(),
                ];
            })->values();
        }),
        ];
    }
}

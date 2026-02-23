<?php
namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $excursions = $this->excursions->map(function ($excursion) {
            return [
                'id'    => $excursion->id,
                'name'  => $excursion->name[app()->getLocale()] ?? $excursion->name['en'] ?? null,
                'price' => $excursion->price,
                'hours' => $excursion->hours,
            ];
        });
        $times = $this->offerTimes->map(fn($time) => [
            'id'        => $time->id,
            'from_time' => $time->from_time,
            'to_time'   => $time->to_time,
        ]);

        return [
            'id'               => $this->id,
            'image'            => $this->image,
            'name'             => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'start_date'       => $this->start_date,
            'end_date'         => $this->end_date,
            'description'      => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price'            => $this->price,
            'excursions_count' => $this->excursions->count(),
            'excursions'       => $excursions,
            'times'            => $times,
        ];
    }
}

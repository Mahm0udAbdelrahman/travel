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
        $excursionsGroupedByDay = $this->excursions->groupBy(function ($excursion) {
            $day = $excursion->days()->find($excursion->pivot->excursion_day_id);
            return $day ? strtolower($day->day) : 'unknown_day';
        });

        $excursionsByDay = $excursionsGroupedByDay->map(function ($excursions, $dayName) {
            return [
                'day'        => $dayName,
                'excursions' => $excursions->map(function ($excursion) {
                    $day  = $excursion->days()->find($excursion->pivot->excursion_day_id);
                    $time = $day ? $day->times()->find($excursion->pivot->excursion_time_id) : null;
                    return [
                        'id'        => $excursion->id,
                        'name'      => $excursion->name[app()->getLocale()] ?? $excursion->name['en'] ?? null,
                        'price'     => $excursion->price,
                        'hours'     => $excursion->hours,
                        'day'       => $day ? $day->day : null,
                        'from_time' => $time ? $time->from_time : null,
                        'to_time'   => $time ? $time->to_time : null,
                    ];
                }),
            ];
        })->values();

        return [
            'id'                => $this->id,
            'image'             => $this->image,
            'name'              => $this->name[app()->getLocale()] ?? $this->name['en'] ?? null,
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
            'description'       => $this->description[app()->getLocale()] ?? $this->description['en'] ?? null,
            'price'             => $this->price,
            'excursions_count'  => $this->excursions()->count(),
            'excursions_by_day' => $excursionsByDay,
        ];
    }
}

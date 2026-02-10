<?php
namespace App\Services\Dashboard;

use App\Models\CategoryExcursion;
use App\Models\City;
use App\Models\Excursion;
use App\Models\Offer;
use App\Traits\HasImage;

class OfferService
{
    use HasImage;
    public function __construct(public Offer $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }
    public function getCategoryExcursions()
    {
        return CategoryExcursion::active()->get();
    }
    public function getExcursions()
    {
        return Excursion::active()->with('city')
            ->get();

    }

    public function getCities()
    {
        return City::active()->get();
    }

    public function store($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'excursion');
        }

        $offer = $this->model->create($data);

        $attachData = [];

        $excursionIds = $data['excursion_ids'] ?? [];
        $days         = $data['days'] ?? [];
        $times        = $data['times'] ?? [];

        foreach ($excursionIds as $excursionId) {
            if (isset($days[$excursionId]) && is_array($days[$excursionId])) {
                foreach ($days[$excursionId] as $dayId) {
                    $attachData[$excursionId][] = [
                        'excursion_day_id'  => $dayId,
                        'excursion_time_id' => $times[$excursionId][$dayId] ?? null,
                    ];
                }
            } else {

                $attachData[$excursionId][] = [
                    'excursion_day_id'  => null,
                    'excursion_time_id' => null,
                ];
            }
        }

        foreach ($attachData as $excursionId => $daysTimesArray) {
            foreach ($daysTimesArray as $pivotData) {
                $offer->excursions()->attach($excursionId, $pivotData);
            }
        }

        return $offer;
    }
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $offer = $this->model->findOrFail($id);

        if (isset($data['image'])) {
            if ($offer->image) {
                \Storage::delete('excursion/' . $offer->image);
            }
            $data['image'] = $this->saveImage($data['image'], 'excursion');
        }

        $offer->update($data);


        $offer->excursions()->detach();

        $attachData = [];

        $excursionIds = $data['excursion_ids'] ?? [];
        $days         = $data['days'] ?? []; 
        $times        = $data['times'] ?? [];

        foreach ($excursionIds as $excursionId) {
            if (isset($days[$excursionId]) && is_array($days[$excursionId])) {
                foreach ($days[$excursionId] as $dayId) {
                    $attachData[$excursionId][] = [
                        'excursion_day_id'  => $dayId,
                        'excursion_time_id' => $times[$excursionId][$dayId] ?? null,
                    ];
                }
            } else {
                $attachData[$excursionId][] = [
                    'excursion_day_id'  => null,
                    'excursion_time_id' => null,
                ];
            }
        }

        foreach ($attachData as $excursionId => $daysTimesArray) {
            foreach ($daysTimesArray as $pivotData) {
                $offer->excursions()->attach($excursionId, $pivotData);
            }
        }

        return $offer;
    }

    public function destroy($id)
    {
        $excursion = $this->show($id);

        $excursion->delete();

        return $excursion;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

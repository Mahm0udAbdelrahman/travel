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
            $attachData[$excursionId] = [
                'excursion_day_id'  => $days[$excursionId] ?? null,
                'excursion_time_id' => $times[$excursionId] ?? null,
            ];
        }

        $offer->excursions()->attach($attachData);

        return $offer;
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $offer = $this->show($id);

        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'excursion');
        }

        $offer->update($data);

        $attachData = [];

        $excursionIds = $data['excursion_ids'] ?? [];
        $days         = $data['days'] ?? [];
        $times        = $data['times'] ?? [];

        foreach ($excursionIds as $excursionId) {
            $attachData[$excursionId] = [
                'excursion_day_id'  => $days[$excursionId] ?? null,
                'excursion_time_id' => $times[$excursionId] ?? null,
            ];
        }

        $offer->excursions()->sync($attachData);

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

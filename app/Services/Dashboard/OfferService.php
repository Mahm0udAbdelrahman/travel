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
            $data['image'] = $this->saveImage($data['image'], 'offer');
        }

        $offer = $this->model->create($data);

        $excursionIds = $data['excursion_ids'] ?? [];
        $times        = $data['times'] ?? [];

        foreach ($excursionIds as $excursionId) {

            if (empty($times[$excursionId])) {
                $offer->excursions()->attach($excursionId);
            }
        }

        $times = $data['times'] ?? [];
        unset($data['times']);

        foreach ($times as $time) {
            $from_time = \Carbon\Carbon::createFromFormat('H:i', $time['from_time'])->format('h:i A');
            $to_time   = \Carbon\Carbon::createFromFormat('H:i', $time['to_time'])->format('h:i A');

            $offer->offerTimes()->create([
                'from_time' => $from_time,
                'to_time'   => $to_time,
            ]);
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
                \Storage::delete('offer/' . $offer->image);
            }
            $data['image'] = $this->saveImage($data['image'], 'offer');
        }

        $offer->update($data);

        $offer->excursions()->detach();

        $excursionIds = $data['excursion_ids'] ?? [];
        $times        = $data['times'] ?? [];

        foreach ($excursionIds as $excursionId) {

            if (empty($times[$excursionId])) {
                $offer->excursions()->attach($excursionId);
            }

        }

        $times = $data['times'] ?? [];
        unset($data['times']);

        $offer->offerTimes()->delete();

        foreach ($times as $time) {
            $from_time = \Carbon\Carbon::createFromFormat('H:i', $time['from_time'])->format('h:i A');
            $to_time   = \Carbon\Carbon::createFromFormat('H:i', $time['to_time'])->format('h:i A');

            $offer->offerTimes()->create([
                'from_time' => $from_time,
                'to_time'   => $to_time,
            ]);
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

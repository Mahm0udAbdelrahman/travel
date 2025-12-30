<?php
namespace App\Services\Dashboard;

use App\Models\City;
use App\Models\Offer;
use App\Traits\HasImage;
use App\Models\Excursion;
use App\Models\CategoryExcursion;

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
        $offer->excursions()->attach($data['excursion_ids'] ?? []);
        return $offer;
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $excursion = $this->show($id);
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'excursion');
        }

        $excursion->update($data);

        $excursion->excursions()->sync($data['excursion_ids'] ?? []);

        return $excursion;

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

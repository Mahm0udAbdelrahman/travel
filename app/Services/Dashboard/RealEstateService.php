<?php
namespace App\Services\Dashboard;

use App\Models\CategoryRealEstate;
use App\Models\City;
use App\Models\RealEstate;
use App\Traits\HasImage;

class RealEstateService
{
    use HasImage;
    public function __construct(public RealEstate $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function getCategoryRealEstates()
    {
        return CategoryRealEstate::active()->get();
    }
    public function getCities()
    {
        return City::active()->get();
    }

    public function store($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'RealEstate');
        }

        return $this->model->create($data);

    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $realEstate = $this->show($id);
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'RealEstate');
        }

        $realEstate->update($data);

        return $realEstate;

    }

    public function destroy($id)
    {
        $realEstate = $this->show($id);

        $realEstate->delete();

        return $realEstate;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

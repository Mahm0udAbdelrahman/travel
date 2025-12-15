<?php
namespace App\Services\Dashboard;

use App\Models\City;
use App\Traits\HasImage;

class CityService
{
    use HasImage;
    public function __construct(public City $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function store($data)
    {

        return $this->model->create($data);


    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $city = $this->show($id);

        $city->update($data);

        return $city;

    }

    public function destroy($id)
    {
        $city = $this->show($id);

        $city->delete();

        return $city;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

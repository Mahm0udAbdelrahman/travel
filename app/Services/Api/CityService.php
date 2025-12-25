<?php
namespace App\Services\Api;

use App\Models\City;

class CityService
{
    public function __construct(public City $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

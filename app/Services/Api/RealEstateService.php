<?php
namespace App\Services\Api;

use App\Models\RealEstate;

class RealEstateService
{
    public function __construct(public RealEstate $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

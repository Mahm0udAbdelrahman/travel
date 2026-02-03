<?php

namespace App\Services\Api\User;

use App\Models\CategoryRealEstate;

class CategoryRealEstateService
{
    public function __construct(public CategoryRealEstate $model) {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }
}

<?php
namespace App\Services\Api;

use App\Models\CategoryExcursion;

class CategoryExcursionService
{
    public function __construct(public CategoryExcursion $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

<?php
namespace App\Services\Api;

use App\Models\SubCategoryExcursion;

class SubCategoryExcursionService
{
    public function __construct(public SubCategoryExcursion $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }





}

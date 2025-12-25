<?php
namespace App\Services\Api;

use App\Models\Excursion;

class ExcursionService
{
    public function __construct(public Excursion $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

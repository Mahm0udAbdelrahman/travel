<?php
namespace App\Services\Api;

use App\Models\AdditionalService;

class AdditionalServiceService
{
    public function __construct(public AdditionalService $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

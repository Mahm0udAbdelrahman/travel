<?php
namespace App\Services\Api;

use App\Models\Excursion;
use App\Traits\HasImage;

class ExcursionService
{
    use HasImage;
    public function __construct(public Excursion $model)
    {}

    public function index()
    {
        return $this->model->where('is_active','1')->latest()->paginate(10);
    }



}

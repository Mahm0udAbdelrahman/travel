<?php
namespace App\Services\Api;

use App\Models\City;
use App\Traits\HasImage;

class CityService
{
    use HasImage;
    public function __construct(public City $model)
    {}

    public function index()
    {
        return $this->model->where('is_active','1')->latest()->paginate(10);
    }

   

}

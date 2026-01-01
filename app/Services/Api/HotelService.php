<?php
namespace App\Services\Api;

use App\Models\Hotel;

class HotelService
{
    public function __construct(public Hotel $model)
    {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }



}

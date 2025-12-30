<?php
namespace App\Services\Api;

use App\Models\RealEstate;

class RealEstateService
{
    public function __construct(public RealEstate $model)
    {}

    public function index($categoryRealEstateId = null)
    {
        $query = $this->model->when($categoryRealEstateId, function ($q) use ($categoryRealEstateId) {
            $q->where('category_real_estate_id', $categoryRealEstateId);
        });
        return $query->active()->latest()->paginate(10);
    }



}

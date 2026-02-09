<?php

namespace App\Services\Api\User;

use App\Models\Excursion;

class ExcursionService
{
    public function __construct(public Excursion $model) {}

    public function index($categoryId = null, $subCategoryId = null)
    {
        return $this->model->with(['days.times', 'categoryExcursion', 'subcategoryExcursion', 'city'])
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_excursion_id', $categoryId);
            })
            ->when($subCategoryId, function ($q) use ($subCategoryId) {
                $q->where('sub_category_excursion_id', $subCategoryId);
            })
            ->latest()
            ->paginate(10);
    }
}

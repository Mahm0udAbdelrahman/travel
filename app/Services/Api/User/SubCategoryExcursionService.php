<?php
namespace App\Services\Api\User;

use App\Models\SubCategoryExcursion;

class SubCategoryExcursionService
{
    public function __construct(public SubCategoryExcursion $model)
    {}

    public function index($categoryId = null)
    {

        return $this->model->with(['categoryExcursion'])
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_excursion_id', $categoryId);
            })->
            active()
            ->latest()
            ->paginate(10);
    }
}

<?php
namespace App\Services\Api;

use App\Models\Excursion;

class ExcursionService
{
    public function __construct(public Excursion $model)
    {}

    public function index($categoryId = null)
    {
        return $this->model
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_excursion_id', $categoryId);
            })
            ->latest()
            ->paginate(10);
    }

}

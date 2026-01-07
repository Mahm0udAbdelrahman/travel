<?php
namespace App\Services\Dashboard;

use App\Models\CategoryExcursion;
use App\Models\SubCategoryExcursion;
use App\Traits\HasImage;

class SubCategoryExcursionService
{
    use HasImage;
    public function __construct(public SubCategoryExcursion $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }
    public function getCategoryExcursions()
    {
        return CategoryExcursion::active()->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $subcategoryExcursion = $this->show($id);

        $subcategoryExcursion->update($data);

        return $subcategoryExcursion;
    }

    public function destroy($id)
    {
        $subcategoryExcursion = $this->show($id);

        $subcategoryExcursion->delete();

        return $subcategoryExcursion;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

<?php
namespace App\Services\Dashboard;

use App\Models\CategoryExcursion;
use App\Traits\HasImage;

class CategoryExcursionService
{
    use HasImage;
    public function __construct(public CategoryExcursion $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
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
        $categoryExcursion = $this->show($id);

        $categoryExcursion->update($data);

        return $categoryExcursion;
    }

    public function destroy($id)
    {
        $categoryExcursion = $this->show($id);

        $categoryExcursion->delete();

        return $categoryExcursion;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

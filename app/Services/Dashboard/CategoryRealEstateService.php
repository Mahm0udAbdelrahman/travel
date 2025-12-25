<?php
namespace App\Services\Dashboard;

use App\Models\CategoryRealEstate;
use App\Traits\HasImage;

class CategoryRealEstateService
{
    use HasImage;
    public function __construct(public CategoryRealEstate $model)
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
        $categoryRealEstate = $this->show($id);

        $categoryRealEstate->update($data);

        return $categoryRealEstate;
    }

    public function destroy($id)
    {
        $categoryRealEstate = $this->show($id);

        $categoryRealEstate->delete();

        return $categoryRealEstate;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

<?php
namespace App\Services\Dashboard;

use App\Models\CategoryEvent;
use App\Traits\HasImage;

class CategoryEventService
{
    use HasImage;
    public function __construct(public CategoryEvent $model)
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
        $categoryEvent = $this->show($id);

        $categoryEvent->update($data);

        return $categoryEvent;
    }

    public function destroy($id)
    {
        $categoryEvent = $this->show($id);

        $categoryEvent->delete();

        return $categoryEvent;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

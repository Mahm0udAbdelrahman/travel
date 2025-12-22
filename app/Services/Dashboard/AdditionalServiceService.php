<?php
namespace App\Services\Dashboard;

use App\Models\AdditionalService;
use App\Traits\HasImage;

class AdditionalServiceService
{
    use HasImage;
    public function __construct(public AdditionalService $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function store($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'AdditionalService');
        }

        return $this->model->create($data);

    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $additional_service = $this->show($id);
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'AdditionalService');
        }

        $additional_service->update($data);

        return $additional_service;

    }

    public function destroy($id)
    {
        $excursion = $this->show($id);

        $excursion->delete();

        return $excursion;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

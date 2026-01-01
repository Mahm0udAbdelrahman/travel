<?php
namespace App\Services\Dashboard;

use App\Models\Hotel;
use App\Traits\HasImage;

class HotelService
{
    use HasImage;
    public function __construct(public Hotel $model)
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
        $hotel = $this->show($id);

        $hotel->update($data);

        return $hotel;
    }

    public function destroy($id)
    {
        $hotel = $this->show($id);

        $hotel->delete();

        return $hotel;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

<?php
namespace App\Services\Dashboard;

use App\Models\OrderAdditionalService;


class OrderAdditionalServiceService
{
    public function __construct(public OrderAdditionalService $model)
    {}
    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $city = $this->show($id);

        $city->update($data);

        return $city;

    }

    public function destroy($id)
    {
        $city = $this->show($id);

        $city->delete();

        return $city;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }



}

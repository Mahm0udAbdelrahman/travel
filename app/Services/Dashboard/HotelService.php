<?php
namespace App\Services\Dashboard;

use App\Models\Hotel;
use App\Models\User;
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
        $hotel = $this->model->create($data);
        $hotel->tourLeaders()->attach($data['tour_leader_ids'] ?? []);
        return $hotel;

    }
    public function getTourLeaders()
    {
        return User::whereDoesntHave('roles')
            ->where('is_active', '!=', 0)
            ->whereNotIn('type', ['customer', 'supplier'])
            ->get();
    }

    public function show($id)
    {
       $hotel = $this->model->with([
            'tourLeaders',
            'orders' => function ($query) {
                $query->orderBy('date', 'desc');
            }
        ])->findOrFail($id);

        $ordersGroupedByDate = $hotel->orders->groupBy('date');

        return [
            'hotel' => $hotel,
            'ordersGroupedByDate' => $ordersGroupedByDate,
        ];
    }

    public function update($id, $data)
    {
        $hotel =$this->model->findOrFail($id);

        $hotel->update($data);
        $hotel->tourLeaders()->sync($data['tour_leader_ids'] ?? []);
        return $hotel;
    }

    public function destroy($id)
    {
        $hotel = $this->model->findOrFail($id);

        $hotel->delete();

        return $hotel;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

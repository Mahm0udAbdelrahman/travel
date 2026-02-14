<?php
namespace App\Services\Dashboard;

use Carbon\Carbon;
use App\Models\User;
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
       $hotel = Hotel::with('tourLeaders', 'orders')->findOrFail($id);

        $orders = $hotel->orders;

        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();
        $dayBeforeYesterday = $today->copy()->subDays(2);
        $tomorrow = $today->copy()->addDay();
        $dayAfterTomorrow = $today->copy()->addDays(2);

        $ordersByPeriod = [
            'today' => $orders->filter(fn($order) => Carbon::parse($order->date)->isSameDay($today)),
            'yesterday' => $orders->filter(fn($order) => Carbon::parse($order->date)->isSameDay($yesterday)),
            'day_before_yesterday' => $orders->filter(fn($order) => Carbon::parse($order->date)->isSameDay($dayBeforeYesterday)),
            'tomorrow' => $orders->filter(fn($order) => Carbon::parse($order->date)->isSameDay($tomorrow)),
            'day_after_tomorrow' => $orders->filter(fn($order) => Carbon::parse($order->date)->isSameDay($dayAfterTomorrow)),
            'all' => $orders->sortByDesc('date'),
        ];

        return [
            'hotel' => $hotel,
            'ordersByPeriod' => $ordersByPeriod,
        ];
    }
    public function edit($id)
    {
        return Hotel::with('tourLeaders', 'orders')->findOrFail($id);
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

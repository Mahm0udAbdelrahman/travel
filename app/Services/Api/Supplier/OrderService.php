<?php

namespace App\Services\Api\Supplier;

use App\Models\Excursion;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderService
{
    public function __construct(public Order $model) {}

    public function index()
    {
        $userId = auth()->id();

        $orders = $this->model
            ->with('orderable')

            // نوع الاوردر excursion لنفس الفئة
            ->whereHasMorph('orderable', [Excursion::class], function ($q) {
                $q->where('category_excursion_id', auth()->user()->category_excursion_id);
            })

            // ❌ استبعد الاوردر لو أنا عملتله rejected
            ->whereDoesntHave('orderStatuses', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('status', 'rejected');
            })

            // ❌ استبعد الاوردر لو حد غيري عمله accepted
            ->whereDoesntHave('orderStatuses', function ($q) use ($userId) {
                $q->where('status', 'accepted')
                    ->where('user_id', '!=', $userId);
            })

            ->latest()
            ->paginate();

        return $orders;
    }


    public function updateOrderStatus($id, $data)
    {
        $order = $this->model->findOrFail($id);
        $order->orderStatuses()->updateOrCreate(
            [
                'user_id' => auth()->id()
            ],[
                'status' => $data['status'],
            ]);

        return $order;
    }
}

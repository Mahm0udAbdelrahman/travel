<?php
namespace App\Services\Api\Supplier;

use App\Models\Excursion;
use App\Models\Order;

class OrderService
{
    public function __construct(public Order $model)
    {}

    public function index()
    {
        $userId = auth()->id();

        $orders = $this->model
            ->with('orderable')
            ->whereHasMorph('orderable', [Excursion::class], function ($q) {
                $q->where('category_excursion_id', auth()->user()->category_excursion_id);
            })
            ->whereDoesntHave('orderStatuses', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('status', 'rejected');
            })
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

        $exists = $order->orderStatuses()
            ->where('user_id', auth()->id())
            ->where('status', $data['status'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'exists',
                'message' => 'أنت بالفعل وافقت على هذا الطلب.',
            ]);
        }

        $order->orderStatuses()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ], [
                'status' => $data['status'],
            ]
        );

        return $order;
    }
}

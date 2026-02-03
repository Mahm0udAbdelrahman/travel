<?php

namespace App\Services\Api\Supplier;

use App\Models\Excursion;
use App\Models\Order;

class OrderService
{
    public function __construct(public Order $model) {}

    public function index()
    {
        $orders = $this->model
            ->with('orderable')
            ->whereHasMorph('orderable', [Excursion::class], function ($q) {
                $q->where('category_excursion_id', auth()->user()->category_excursion_id);
            })
            ->latest()
            ->paginate();

        return $orders;
    }
}

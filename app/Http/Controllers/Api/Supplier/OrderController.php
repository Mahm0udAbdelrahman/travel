<?php

namespace App\Http\Controllers\Api\Supplier;


use App\Traits\HttpResponse;
use App\Services\Api\Supplier\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Supplier\Order\OrderRequest;
use App\Http\Resources\User\OrderResource;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService) {}
    public function index()
    {
        $order = $this->orderService->index();
        return $this->paginatedResponse($order, OrderResource::class);
    }

    public function updateOrderStatus($id, OrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->orderService->updateOrderStatus($id, $data);
        return $this->successResponse($order, OrderResource::class);
    }
}

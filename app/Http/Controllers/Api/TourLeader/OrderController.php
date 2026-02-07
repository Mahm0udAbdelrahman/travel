<?php
namespace App\Http\Controllers\Api\TourLeader;

use App\Traits\HttpResponse;
use App\Http\Controllers\Controller;
use App\Services\Api\TourLeader\OrderService;
use App\Http\Requests\Api\TourLeader\Order\OrderRequest;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService)
    {}
    public function store(OrderRequest $orderRequest)
    {
        return $this->orderService->store($orderRequest->validated());
    }

}

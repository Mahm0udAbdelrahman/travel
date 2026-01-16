<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Models\Order;
use App\Services\Api\OrderService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService)
    {}
    public function store(OrderRequest $orderRequest)
    {

        $method = $orderRequest->payment_method == 'cash' ? 'cashOrder' : 'store';
        return $this->orderService->$method($orderRequest->validated());

    }
   

}

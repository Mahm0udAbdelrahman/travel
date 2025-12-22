<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderAdditionalService\OrderAdditionalServiceRequest;
use App\Services\Api\OrderAdditionalServiceService;
use App\Traits\HttpResponse;

class OrderAdditionalServiceController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderAdditionalServiceService $orderAdditionalServiceService)
    {}
    public function store(OrderAdditionalServiceRequest $request)
    {
        $this->orderAdditionalServiceService->store($request->validated());
        return $this->successResponse([], __('messages.order_additional_service_created'));

    }

}

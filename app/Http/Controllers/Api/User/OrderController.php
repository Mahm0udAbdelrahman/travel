<?php

namespace App\Http\Controllers\Api\User;

use Stripe\Webhook;
use App\Models\Order;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\Api\User\OrderService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\OrderResource;
use App\Http\Requests\Api\User\Order\OrderRequest;
use Stripe\Exception\SignatureVerificationException;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService) {}
    public function store(OrderRequest $orderRequest)
    {

        $method = $orderRequest->payment_method == 'cash' ? 'cashOrder' : 'store';
        return $this->orderService->$method($orderRequest->validated());
    }

    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $secret
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe Webhook Signature Error', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Error', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $order = Order::where('payment_id', $session->id)->first();

            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'completed',
                ]);
            }
        }

        if ($event->type === 'payment_intent.payment_failed') {
            $intent = $event->data->object;

            Order::where('payment_id', $intent->id)->update([
                'payment_status' => 'failed',
                'status'         => 'cancelled',
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function myOrder()
    {
        $order = $this->orderService->myOrder();
        return $this->paginatedResponse($order, OrderResource::class);
    }
}

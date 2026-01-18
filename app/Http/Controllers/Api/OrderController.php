<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Models\Order;
use App\Services\Api\OrderService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService)
    {}
    public function store(OrderRequest $orderRequest)
    {

        $method = $orderRequest->payment_method == 'cash' ? 'cashOrder' : 'store';
        return $this->orderService->$method($orderRequest->validated());
سفقهح
    }

    public function handle(Request $request)
    {
        $payload    = $request->getContent();
        $sigHeader  = $request->header('Stripe-Signature');
        $secret     = env('STRIPE_WEBHOOK_SECRET');

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

        /**
         * event types
         */
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


}

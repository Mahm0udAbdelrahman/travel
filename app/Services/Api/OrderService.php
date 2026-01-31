<?php
namespace App\Services\Api;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class OrderService
{
    public function __construct(public Order $model)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function cashOrder($data)
    {
        $user = auth()->user();

        $map = [
            'real_estate'        => \App\Models\RealEstate::class,
            'event'              => \App\Models\Event::class,
            'excursion'          => \App\Models\Excursion::class,
            'offer'              => \App\Models\Offer::class,
            'additional_service' => \App\Models\AdditionalService::class,
        ];

        if (! isset($map[$data['type_model']])) {
            return ['success' => false, 'message' => 'نوع المنتج غير صالح'];
        }

        $item       = $map[$data['type_model']]::findOrFail($data['id']);
        $quantity   = $data['quantity'] ?? 1;
        $price      = $item->price ?? 1;
        $totalPrice = $price * $quantity;

        return $this->model->create([
            'user_id'        => $user->id,
            'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
            'price'          => $totalPrice,
            'quantity'       => $quantity,
            'status'         => 'completed',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'orderable_id'   => $item->id,
            'orderable_type' => get_class($item),
            'hotel_id'       => $data['hotel_id'] ?? null,
            'room_number'    => $data['room_number'] ?? null,
        ]);
    }

    // public function store(array $data)
    // {
    //     $user = auth()->user();

    //     if (! $user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'المستخدم غير موجود',
    //         ], 401);
    //     }

    //     $map = [
    //         'real_estate' => \App\Models\RealEstate::class,
    //         'event'       => \App\Models\Event::class,
    //         'excursion'   => \App\Models\Excursion::class,
    //         'offer'       => \App\Models\Offer::class,
    //     ];

    //     if (! isset($map[$data['type']])) {
    //         return response()->json(['success' => false, 'message' => 'نوع المنتج غير صالح'], 422);
    //     }

    //     $item       = $map[$data['type']]::findOrFail($data['id']);
    //     $quantity   = $data['quantity'] ?? 1;
    //     $totalPrice = $item->price * $quantity;

    //     try {
    //         $session = StripeSession::create([
    //             'payment_method_types' => ['card'],
    //             'mode' => 'payment',
    //             'customer_email' => $user->email,
    //             'line_items' => [[
    //                 'price_data' => [
    //                     'currency' => 'usd',
    //                     'product_data' => [
    //                         'name' =>  $item->name['en'] ?? 'Default Product Name',
    //                     ],
    //                     'unit_amount' => (int) ($item->price * 100),
    //                 ],
    //                 'quantity' => $quantity,
    //             ]],
    //             'success_url' => url('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
    //             'cancel_url'  => url('/payment/cancel'),
    //         ]);

    //         $order = $this->model->create([
    //             'user_id'        => $user->id,
    //             'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
    //             'price'          => $totalPrice,
    //             'currency'       => 'USD',
    //             'quantity'       => $quantity,
    //             'status'         => 'pending',
    //             'payment_method' => $data['payment_method'] ?? 'stripe',
    //             'payment_id'     => $session->id,
    //             'orderable_id'   => $item->id,
    //             'orderable_type' => get_class($item),
    //             'hotel_id'       => $data['hotel_id'] ?? null,
    //             'room_number'    => $data['room_number'] ?? null,
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'order_number' => $order->order_number,
    //             'redirect_url' => $session->url,
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('Stripe Error', ['error' => $e->getMessage()]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'فشل إنشاء عملية الدفع',
    //         ], 500);
    //     }
    // }

    public function store(array $data)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير موجود',
            ], 401);
        }

        $map = [
            'real_estate'        => \App\Models\RealEstate::class,
            'event'              => \App\Models\Event::class,
            'excursion'          => \App\Models\Excursion::class,
            'offer'              => \App\Models\Offer::class,
            'additional_service' => \App\Models\AdditionalService::class,
        ];

        if (! isset($map[$data['type_model']])) {
            return response()->json(['success' => false, 'message' => 'نوع المنتج غير صالح'], 422);
        }

        $item       = $map[$data['type_model']]::findOrFail($data['id']);
        $quantity   = $data['quantity'] ?? 1;
        $price      = $item->price ?? 1;
        $totalPrice = $price * $quantity;

        if (in_array($data['type_model'], ['real_estate', 'additional_service'])) {

            $order = $this->model->create([
                'user_id'        => $user->id,
                'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                'price'          => $totalPrice,
                'currency'       => 'USD',
                'quantity'       => $quantity,
                'status'         => 'completed',
                'payment_method' => 'free_event',
                'payment_status' => 'paid',
                'orderable_id'   => $item->id,
                'orderable_type' => get_class($item),
                'hotel_id'       => $data['hotel_id'] ?? null,
                'room_number'    => $data['room_number'] ?? null,
            ]);

            return response()->json([
                'success'      => true,
                'message'      => 'تم تسجيل الاشتراك في الحدث بنجاح',
                'order_number' => $order->order_number,
            ]);
        }

        try {

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'mode'                 => 'payment',
                'customer_email'       => $user->email,
                'line_items'           => [[
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $item->name['en'] ?? 'Default Product Name',
                        ],
                        'unit_amount'  => (int) ($item->price * 100),
                    ],
                    'quantity'   => $quantity,
                ]],
                'success_url'          => url('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url'           => url('/payment/cancel'),
            ]);

            $order = $this->model->create([
                'user_id'        => $user->id,
                'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                'price'          => $totalPrice,
                'currency'       => 'USD',
                'quantity'       => $quantity,
                'status'         => 'pending',
                'payment_method' => $data['payment_method'] ?? 'stripe',
                'payment_id'     => $session->id,
                'orderable_id'   => $item->id,
                'orderable_type' => get_class($item),
                'hotel_id'       => $data['hotel_id'] ?? null,
                'room_number'    => $data['room_number'] ?? null,
            ]);

            return response()->json([
                'success'      => true,
                'order_number' => $order->order_number,
                'redirect_url' => $session->url,
            ]);

        } catch (\Exception $e) {

            Log::error('Stripe Error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'فشل إنشاء عملية الدفع',
            ], 500);
        }
    }

    public function myOrder()
    {
        $user = auth()->user();
        return $this->model->where('user_id', $user->id)->first();
    }

}

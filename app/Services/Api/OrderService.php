<?php
namespace App\Services\Api;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService
{
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;
    protected $cardId;
    protected $api_key;
    protected $walletId;
    protected $walletIdFrame;
    protected $cardIdFrame;

    public function __construct(public Order $model)
    {
        $this->baseUrl       = env('PAYMOB_API_URL');
        $this->secretKey     = env('PAYMOB_SECRET_KEY');
        $this->publicKey     = env('PAYMOB_PUBLIC_KEY');
        $this->cardId        = env('PAYMOB_INTEGRATION_ID');
        $this->walletId      = env('PAYMOB_WALLET_INTEGRATION_ID');
        $this->api_key       = env('PAYMOB_API_KEY');
        $this->cardIdFrame   = env('PAYMOB_IFRAME_ID');
        $this->walletIdFrame = env('PAYMOB_WALLET_IFRAME_ID');
    }

    public function cashOrder($data)
    {
        $user = auth()->user();

        $map = [
            'real_estate' => \App\Models\RealEstate::class,
            'event'       => \App\Models\Event::class,
            'excursion'   => \App\Models\Excursion::class,
            'offer'       => \App\Models\Offer::class,
        ];

        if (! isset($map[$data['type']])) {
            return ['success' => false, 'message' => 'نوع المنتج غير صالح'];
        }

        $modelClass = $map[$data['type']];
        $item       = $modelClass::findOrFail($data['id']);

        $quantity   = $data['quantity'] ?? 1;
        $totalPrice = $item->price * $quantity;

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        $order       = $this->model->create([
            'user_id'        => $user->id,
            'order_number'   => $orderNumber,
            'hotel_id'       => $data['hotel_id'],
            'room_number'    => $data['room_number'],
            'price'          => $totalPrice,
            'quantity'       => $quantity,
            'status'         => 'pending',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'orderable_id'   => $item->id,
            'orderable_type' => $modelClass,
        ]);
        return $order;
    }

    public function store(array $data)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير موجود',
            ], 401);
        }

        $authResponse = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $this->api_key,
        ]);

        if (! $authResponse->successful()) {
            Log::error('Paymob Auth Error', $authResponse->json());
            return response()->json([
                'status'  => false,
                'message' => 'فشل في المصادقة مع Paymob',
            ], 500);
        }

        $authToken = $authResponse->json('token');

        $map = [
            'real_estate' => \App\Models\RealEstate::class,
            'event'       => \App\Models\Event::class,
            'excursion'   => \App\Models\Excursion::class,
            'offer'       => \App\Models\Offer::class,
        ];

        if (! isset($map[$data['type']])) {
            return response()->json([
                'success' => false,
                'message' => 'نوع المنتج غير صالح',
            ], 422);
        }

        $modelClass = $map[$data['type']];
        $item       = $modelClass::findOrFail($data['id']);

        $quantity   = $data['quantity'] ?? 1;
        $totalPrice = $item->price * $quantity;

        $amountCents = (int) round($totalPrice * 100);

        $orderResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type'  => 'application/json',
        ])->post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token'      => $authToken,
            'delivery_needed' => false,
            'amount_cents'    => $amountCents,
            'currency'        => 'EGP',
            'items'           => [],
        ]);

        if (! $orderResponse->successful()) {
            Log::error('Paymob Order Error', $orderResponse->json());
            return response()->json([
                'status'  => false,
                'message' => 'فشل في إنشاء الطلب في Paymob',
            ], 500);
        }

        $paymobOrderId = $orderResponse->json('id');

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        $order = $this->model->create([
            'user_id'         => $user->id,
            'order_number'    => $orderNumber,
            'price'           => $totalPrice,
            'currency'        => 'EGP',
            'quantity'        => $quantity,
            'status'          => 'pending',
            'orderable_id'    => $item->id,
            'orderable_type'  => $modelClass,
            'hotel_id'        => $data['hotel_id'] ?? null,
            'room_number'     => $data['room_number'] ?? null,
            'payment_method'   => 'card',
            'payment_id'       => $paymobOrderId,
        ]);

        $billing = [
            'apartment'       => 'NA',
            'first_name'      => $user->name,
            'last_name'       => 'Guest',
            'street'          => 'NA',
            'building'        => 'NA',
            'phone_number'    => $user->phone ?? '0000000000',
            'city'            => 'NA',
            'state'           => 'NA',
            'country'         => $data['country'] ?? 'US',
            'email'           => $user->email,
            'floor'           => 'NA',
            'postal_code'     => '00000',
            'shipping_method' => 'PKG',
        ];

        $integrationId = request()->input('payment_method') === 'card'
            ? $this->cardId
            : $this->walletId;

        $paymentKeyResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type'  => 'application/json',
        ])->post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token'     => $authToken,
            'amount_cents'   => $amountCents,
            'expiration'     => 3600,
            'order_id'       => $paymobOrderId,
            'billing_data'   => $billing,
            'currency'       => 'EGP',
            'integration_id' => $integrationId,
        ]);

        if (! $paymentKeyResponse->successful()) {
            Log::error('Paymob Payment Key Error', $paymentKeyResponse->json());
            return response()->json([
                'status'  => false,
                'message' => 'فشل في إنشاء مفتاح الدفع',
            ], 500);
        }

        $paymentKey = $paymentKeyResponse->json('token');

        $iframeId = request()->input('payment_method') === 'card'
            ? env('PAYMOB_IFRAME_ID')
            : env('PAYMOB_WALLET_IFRAME_ID');

        return response()->json([
            'success'      => true,
            'order_number' => $orderNumber,
            'amount'       => $totalPrice,
            'currency'     => 'EGP',
            'redirect_url' => "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentKey}",
        ]);
    }

}

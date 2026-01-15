<?php

namespace App\Services\Api;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private $opayMerchantId;
    private $opaySecretKey;
    private $opayBaseUrl;

    public function __construct(public Order $model)
    {
        // $this->opayMerchantId = config('services.opay.merchant_id');
        // $this->opaySecretKey = config('services.opay.secret_key');
        // $this->opayBaseUrl = config('services.opay.base_url', 'https://api.opaycheckout.com');
        $this->opayMerchantId = '281825072114267';
        $this->opaySecretKey = 'OPAYPRV17531054178030.4319669325059483';
        $this->opayBaseUrl = 'https://api.opaycheckout.com';
    }

    public function store($data)
    {
        $user = auth()->user();

        $map = [
            'real_estate' => \App\Models\RealEstate::class,
            'event'       => \App\Models\Event::class,
            'excursion'   => \App\Models\Excursion::class,
            'offer'       => \App\Models\Offer::class,
        ];

        if (!isset($map[$data['type']])) {
            throw new \Exception('نوع المنتج غير صالح');
        }

        $modelClass = $map[$data['type']];
        $item = $modelClass::findOrFail($data['id']);

        $quantity = $data['quantity'] ?? 1;
        $totalPrice = $item->price * $quantity;

        $this->model->where('user_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        try {
            $payload = [
                'reference'   => $orderNumber,
                'amount'      => [
                    'currency' => 'EGP',
                    'total'    => $totalPrice * 100,
                ],
                'callbackUrl' => route('payment.opay.callback'), // المسار الذي يستقبل رد السيستم
                'returnUrl'   => route('payment.opay.return'),   // المسار الذي يعود إليه المستخدم
                'userInfo'    => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'merchantId'  => $this->opayMerchantId,
            ];

            $headers = [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->opaySecretKey,
                'MerchantId'    => $this->opayMerchantId,
            ];

           $response = Http::withHeaders($headers)
    ->post("{$this->opayBaseUrl}/api/v1/international/cashier/create", $payload);

            if ($response->successful() && isset($response->json()['data']['cashierUrl'])) {
                $paymentUrl = $response->json()['data']['cashierUrl'];

                $order = $this->model->create([
                    'user_id'        => $user->id,
                    'order_number'   => $orderNumber,
                    'price'          => $totalPrice,
                    'quantity'       => $quantity,
                    'status'         => 'pending',
                    'orderable_id'   => $item->id,
                    'orderable_type' => $modelClass,
                ]);

                return [
                    'success'      => true,
                    'order_id'     => $order->id,
                    'total_price'  => $totalPrice,
                    'redirect_url' => $paymentUrl,
                ];
            } else {
                Log::error('Opay Error Response:', $response->json());
                return ['success' => false, 'message' => 'فشل في إنشاء طلب الدفع عبر Opay'];
            }

        } catch (\Exception $e) {
            Log::error('Opay Exception:', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'حدث خطأ أثناء معالجة الطلب'];
        }
    }
}

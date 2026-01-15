<?php

namespace App\Services\Api;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private string $opayMerchantId;
    private string $opaySecretKey;
    private string $opayBaseUrl;

    public function __construct(public Order $model)
    {
        $this->opayMerchantId = config('services.opay.merchant_id');
        $this->opaySecretKey  = config('services.opay.secret_key');
        $this->opayBaseUrl    = config('services.opay.base_url');
        // sandbox: https://sandbox.opaycheckout.com
        // live   : https://api.opaycheckout.com
    }

    /**
     * Create Order + OPay Payment
     */
    public function store(array $data): array
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

        $quantity    = $data['quantity'] ?? 1;
        $totalPrice  = $item->price * $quantity;
        $amountCents = (int) ($totalPrice * 100);

        // remove old pending orders
        $this->model
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        try {

            /** -------- OPay Payload -------- */
            $payload = [
                'reference'   => $orderNumber,
                'amount'      => [
                    'currency' => 'EGP',
                    'total'    => $amountCents,
                ],
                'callbackUrl' => route('payment.opay.callback'),
                'returnUrl'   => route('payment.opay.return'),
                'userInfo'    => [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ];


            /** -------- Generate Signature -------- */
            $sign = $this->generateSign([
                'merchantId' => $this->opayMerchantId,
                'reference'  => $orderNumber,
                'amount'     => $amountCents,
                'currency'   => 'EGP',
            ]);
            /** -------- Send Request -------- */
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'MerchantId'   => $this->opayMerchantId,
                'Sign'         => $sign,
            ])->post(
                'https://sandboxapi.opaycheckout.com/api/v3/international/cashier/create',
                $payload
            );

            /** -------- Handle Response -------- */
            if (
                $response->successful() &&
                isset($response['data']['cashierUrl'])
            ) {

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
                    'redirect_url' => $response['data']['cashierUrl'],
                ];
            }

            Log::error('OPay Error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'فشل إنشاء عملية الدفع عبر OPay',
            ];

        } catch (\Throwable $e) {

            Log::error('OPay Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الطلب',
            ];
        }
    }

    /**
     * Generate OPay Signature
     */
    private function generateSign(array $data): string
    {
        ksort($data);

        $string = '';
        foreach ($data as $key => $value) {
            if ($value !== null && $value !== '') {
                $string .= $key . '=' . $value . '&';
            }
        }

        $string .= 'secretKey=' . $this->opaySecretKey;

        return strtoupper(hash('sha256', $string));
    }
}

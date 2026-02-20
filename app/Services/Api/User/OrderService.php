<?php
namespace App\Services\Api\User;

use App\Enums\UserType;
use App\Helpers\SendNotificationHelper;
use App\Models\Order;
use App\Models\User;
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

        $item = $map[$data['type_model']]::findOrFail($data['id']);

        $quantity   = $data['quantity'] ?? 1;
        $price      = $item->price ?? 1;
        $totalPrice = $price * $quantity;

        $date            = null;
        $timeString      = null;
        $excursionTimeId = null;
        $excursionDayId  = null;

        if ($data['type_model'] === 'excursion') {

            $timeModel = \App\Models\ExcursionTime::with('day')->findOrFail($data['time_id']);

            if (! $timeModel->day || $timeModel->day->excursion_id != $item->id) {
                abort(422, 'الوقت غير تابع لهذه الرحلة');
            }

            $date            = $data['date'];
            $timeString      = $timeModel->from_time . '-' . $timeModel->to_time;
            $excursionTimeId = $timeModel->id;
            $excursionDayId  = $timeModel->excursion_day_id;
        }

        $order = $this->model->create([
            'user_id'           => $user->id,
            'order_number'      => 'ORD-' . strtoupper(Str::random(10)),

            'price'             => $totalPrice,
            'quantity'          => $quantity,

            'status'            => 'completed',
            'payment_method'    => 'cash',
            'payment_status'    => 'paid',

            'orderable_id'      => $item->id,
            'orderable_type'    => get_class($item),

            'hotel_id'          => $data['hotel_id'] ?? null,
            'room_number'       => $data['room_number'] ?? null,

            'date'              => $date,
            'time'              => $timeString,
            'excursion_time_id' => $excursionTimeId,
            'excursion_day_id'  => $excursionDayId,
        ]);

        $notificationData = [
            'title_en' => 'New Order Received',
            'body_en'  => "You have a new order for {$item->name['en'] ?? 'a product'}",
            'title_ar' => 'تم استلام طلب جديد',
            'body_ar'  => "لديك طلب جديد لـ {$item->name['ar'] ?? 'منتج'}",
            'order_id' => $order->id,
        ];

        User::where('type', UserType::SUPPLIER)
            ->where('category_excursion_id', $item->category_excursion_id)
            ->chunk(100, function ($users) use ($notificationData) {
                $sendNotificationHelper = new SendNotificationHelper();
                foreach ($users as $user) {
                    if (! empty($user->fcm_token)) {
                        $sendNotificationHelper->sendNotification(
                            $notificationData,
                            [$user->fcm_token]
                        );
                    }
                }
            });

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

        $item = $map[$data['type_model']]::findOrFail($data['id']);

        $quantity   = $data['quantity'] ?? 1;
        $price      = $item->price ?? 1;
        $totalPrice = $price * $quantity;

        $date            = null;
        $timeString      = null;
        $excursionTimeId = null;
        $excursionDayId  = null;

        if ($data['type_model'] === 'excursion') {

            if (empty($data['time_id']) || empty($data['date'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب اختيار اليوم والوقت',
                ], 422);
            }

            $timeModel = \App\Models\ExcursionTime::with('day')->findOrFail($data['time_id']);

            if (! $timeModel->day || $timeModel->day->excursion_id != $item->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'الوقت غير تابع لهذه الرحلة',
                ], 422);
            }

            $date            = $data['date'];
            $timeString      = $timeModel->from_time . '-' . $timeModel->to_time;
            $excursionTimeId = $timeModel->id;
            $excursionDayId  = $timeModel->excursion_day_id;
        }

        if (in_array($data['type_model'], ['real_estate'])) {

            $order = $this->model->create([
                'user_id'        => $user->id,
                'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                'price'          => $totalPrice,
                'currency'       => 'USD',
                'quantity'       => $quantity,
                'status'         => 'completed',
                'payment_method' => 'free',
                'payment_status' => 'paid',

                'orderable_id'   => $item->id,
                'orderable_type' => get_class($item),

                'hotel_id'       => $data['hotel_id'] ?? null,
                'room_number'    => $data['room_number'] ?? null,

                'date'           => $date,
                'time'           => $timeString,
            ]);

            return response()->json([
                'success'      => true,
                'message'      => 'تم التسجيل بنجاح',
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
                            'name' => $item->name['en'] ?? 'Product',
                        ],
                        'unit_amount'  => (int) ($price * 100),
                    ],
                    'quantity'   => $quantity,
                ]],
                'success_url'          => url('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url'           => url('/payment/cancel'),
            ]);

            $order = $this->model->create([
                'user_id'           => $user->id,
                'order_number'      => 'ORD-' . strtoupper(Str::random(10)),
                'price'             => $totalPrice,
                'currency'          => 'USD',
                'quantity'          => $quantity,

                'status'            => 'pending',
                'payment_method'    => $data['payment_method'] ?? 'stripe',
                'payment_id'        => $session->id,

                'orderable_id'      => $item->id,
                'orderable_type'    => get_class($item),

                'hotel_id'          => $data['hotel_id'] ?? null,
                'room_number'       => $data['room_number'] ?? null,

                'date'              => $date,
                'time'              => $timeString,
                'excursion_time_id' => $excursionTimeId,
                'excursion_day_id'  => $excursionDayId,
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

    public function update($id, $data)
    {
        $order = $this->model->findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function myOrder()
    {
        return $this->model
            ->where('user_id', auth()->id())
            ->paginate();
    }
}

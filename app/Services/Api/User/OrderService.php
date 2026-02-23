<?php
namespace App\Services\Api\User;

use App\Enums\UserType;
use App\Helpers\SendNotificationHelper;
use App\Models\Order;
use App\Models\User;
use App\Notifications\DashboardNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class OrderService
{
    public function __construct(public Order $model)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function cashOrder(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = auth()->user();

            $modelMap = [
                'real_estate'        => \App\Models\RealEstate::class,
                'event'              => \App\Models\Event::class,
                'excursion'          => \App\Models\Excursion::class,
                'offer'              => \App\Models\Offer::class,
                'additional_service' => \App\Models\AdditionalService::class,
            ];

            if (! isset($modelMap[$data['type_model']])) {
                abort(422, 'نوع المنتج غير صالح');
            }

            $item = $modelMap[$data['type_model']]::findOrFail($data['id']);

            $quantity = $data['quantity'] ?? 1;
            $price    = $item->price ?? 0;

            $date            = null;
            $timeString      = null;
            $excursionTimeId = null;
            $offerTimeId     = null;

            if ($data['type_model'] === 'excursion') {

                $time = \App\Models\ExcursionTime::where('id', $data['excursion_time_id'] ?? null)
                    ->where('excursion_id', $item->id)
                    ->firstOrFail();

                $date            = $data['date'] ?? abort(422, 'التاريخ مطلوب');
                $timeString      = "{$time->from_time}-{$time->to_time}";
                $excursionTimeId = $time->id;
            }

            if ($data['type_model'] === 'offer') {

                $time = \App\Models\OfferTime::where('id', $data['offer_time_id'] ?? null)
                    ->where('offer_id', $item->id)
                    ->firstOrFail();

                $date        = $data['date'] ?? abort(422, 'التاريخ مطلوب');
                $timeString  = "{$time->from_time}-{$time->to_time}";
                $offerTimeId = $time->id;
            }

            $order = $this->model->create([
                'user_id'           => $user->id,
                'order_number'      => 'ORD-' . strtoupper(Str::random(10)),
                'price'             => $price * $quantity,
                'quantity'          => $quantity,
                'status'            => 'pending',
                'payment_method'    => 'cash',
                'payment_status'    => 'pending',
                'orderable_id'      => $item->id,
                'orderable_type'    => get_class($item),
                'hotel_id'          => $data['hotel_id'] ?? null,
                'room_number'       => $data['room_number'] ?? null,
                'date'              => $date,
                'time'              => $timeString,
                'excursion_time_id' => $excursionTimeId,
                'offer_time_id'     => $offerTimeId,
                'notes'             => $data['notes'] ?? null,
                'is_tour_leader'    => $user->type === UserType::REPRESENTATIVE,
            ]);

            $firestoreData = [
                'id'             => $order->id,
                'order_number'   => $order->order_number,
                'customer_id'    => $user->id,
                'customer_name'  => $user->name,
                'customer_phone' => $user->phone,
                'hotel_id'       => $order->hotel_id,
                'hotel_name'     => $order->hotel?->name[app()->getLocale()] ?? null,
                'name'           => is_array($item->name ?? null)
                    ? $item->name[app()->getLocale()] ?? null
                    : $item->name ?? null,
                'image'          => $item->image ?? null,
                'room_number'    => $order->room_number,
                'quantity'       => $order->quantity,
                'date'           => $order->date,
                'time'           => $order->time,
                'notes'          => $order->notes,
                'price'          => $order->price,
                'status'         => 'pending',
                'payment_method' => 'cash',
                'created_at'     => now()->toDateTimeString(),
            ];

            $firebase = app('firebase.firestore')->database();

            $firebase->collection('customers')
                ->document((string) $user->id)
                ->collection('orders')
                ->document((string) $order->id)
                ->set($firestoreData);

            $notifier = new SendNotificationHelper();

            foreach ($order->hotel?->tourLeaders ?? [] as $leader) {

                if ($leader->fcm_token) {
                    $notifier->sendNotification([
                        'title_en' => 'New Order',
                        'body_en'  => 'A new order assigned to your hotel',
                        'title_ar' => 'طلب جديد',
                        'body_ar'  => 'تم إضافة طلب جديد مرتبط بالفندق',
                        'order_id' => $order->id,
                    ], [$leader->fcm_token]);
                }

                $firebase->collection('tour_leaders')
                    ->document((string) $leader->id)
                    ->collection('orders')
                    ->document((string) $order->id)
                    ->set($firestoreData);
            }

            User::where('type', UserType::SUPPLIER)
                ->where('category_excursion_id', $item->category_excursion_id ?? null)
                ->chunk(100, function ($suppliers) use ($firebase, $firestoreData, $notifier, $order) {

                    foreach ($suppliers as $supplier) {

                        if ($supplier->fcm_token) {
                            $notifier->sendNotification([
                                'title_en' => 'New Order Received',
                                'body_en'  => 'You have a new order',
                                'title_ar' => 'طلب جديد',
                                'body_ar'  => 'لديك طلب جديد',
                                'order_id' => $order->id,
                            ], [$supplier->fcm_token]);
                        }

                        $firebase->collection('suppliers')
                            ->document((string) $supplier->id)
                            ->collection('orders')
                            ->document((string) $order->id)
                            ->set($firestoreData);
                    }
                });

            /**
             * Notify Admin Dashboard
             */
            $admins = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();

            Notification::send(
                $admins,
                new DashboardNotification(
                    $order->id,
                    $user->name,
                    $order->price,
                    'order'
                )
            );

            return $order;
        });
    }
    public function store(array $data)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'المستخدم غير موجود'], 401);
        }

        return DB::transaction(function () use ($data, $user) {

            $modelMap = [
                'real_estate'        => \App\Models\RealEstate::class,
                'event'              => \App\Models\Event::class,
                'excursion'          => \App\Models\Excursion::class,
                'offer'              => \App\Models\Offer::class,
                'additional_service' => \App\Models\AdditionalService::class,
            ];

            if (! isset($modelMap[$data['type_model']])) {
                abort(422, 'نوع المنتج غير صالح');
            }

            $item = $modelMap[$data['type_model']]::findOrFail($data['id']);

            $quantity = $data['quantity'] ?? 1;
            $price    = $item->price ?? 0;

            $date            = null;
            $timeString      = null;
            $excursionTimeId = null;
            $offerTimeId     = null;

            if ($data['type_model'] === 'excursion') {

                if (empty($data['excursion_time_id']) || empty($data['date'])) {
                    abort(422, 'يجب اختيار اليوم والوقت');
                }

                $time = \App\Models\ExcursionTime::where('id', $data['excursion_time_id'])
                    ->where('excursion_id', $item->id)
                    ->firstOrFail();

                $date            = $data['date'];
                $timeString      = "{$time->from_time}-{$time->to_time}";
                $excursionTimeId = $time->id;
            }

            if ($data['type_model'] === 'offer') {

                if (empty($data['offer_time_id']) || empty($data['date'])) {
                    abort(422, 'يجب اختيار اليوم والوقت');
                }

                $time = \App\Models\OfferTime::where('id', $data['offer_time_id'])
                    ->where('offer_id', $item->id)
                    ->firstOrFail();

                $date        = $data['date'];
                $timeString  = "{$time->from_time}-{$time->to_time}";
                $offerTimeId = $time->id;
            }

            /** Free Order (Real Estate) */
            if ($data['type_model'] === 'real_estate') {

                $order = $this->createOrder($user, $item, $data, [
                    'payment_method'    => 'free',
                    'payment_status'    => 'paid',
                    'date'              => $date,
                    'time'              => $timeString,
                    'excursion_time_id' => $excursionTimeId,
                    'offer_time_id'     => $offerTimeId,
                ]);

                return response()->json([
                    'success'      => true,
                    'order_number' => $order->order_number,
                ]);
            }

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'mode'                 => 'payment',
                'customer_email'       => $user->email,
                'line_items'           => [[
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => is_array($item->name) ? ($item->name['en'] ?? 'Product') : $item->name,
                        ],
                        'unit_amount'  => (int) ($price * 100),
                    ],
                    'quantity'   => $quantity,
                ]],
                'success_url'          => url('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url'           => url('/payment/cancel'),
            ]);

            $order = $this->createOrder($user, $item, $data, [
                'payment_method'    => 'stripe',
                'payment_status'    => 'pending',
                'payment_id'        => $session->id,
                'date'              => $date,
                'time'              => $timeString,
                'excursion_time_id' => $excursionTimeId,
                'offer_time_id'     => $offerTimeId,
            ]);

            return response()->json([
                'success'      => true,
                'order_number' => $order->order_number,
                'redirect_url' => $session->url,
            ]);
        });
    }

    private function createOrder($user, $item, array $data, array $extra = [])
    {
        return $this->model->create(array_merge([
            'user_id'        => $user->id,
            'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
            'price'          => ($item->price ?? 0) * ($data['quantity'] ?? 1),
            'currency'       => 'USD',
            'quantity'       => $data['quantity'] ?? 1,
            'status'         => 'pending',
            'orderable_id'   => $item->id,
            'orderable_type' => get_class($item),
            'hotel_id'       => $data['hotel_id'] ?? null,
            'room_number'    => $data['room_number'] ?? null,
        ], $extra));
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

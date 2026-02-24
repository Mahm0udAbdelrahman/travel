<?php
namespace App\Services\Api\TourLeader;

use App\Enums\UserType;
use App\Helpers\SendNotificationHelper;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;

class OrderService
{
    public function __construct(public Order $model)
    {}

    public function store($data)
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

        $order = $this->model->create([
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
            'is_tour_leader' => 1,
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

        $categoryIds = collect();

        if ($data['type_model'] === 'excursion') {

            $categoryIds = collect([$item->category_excursion_id]);

        } elseif ($data['type_model'] === 'offer') {

            $categoryIds = DB::table('excursion_offers')
                ->join('excursions', 'excursions.id', '=', 'excursion_offers.excursion_id')
                ->where('excursion_offers.offer_id', $item->id)
                ->pluck('excursions.category_excursion_id')
                ->unique();
        }

        $factory = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));
        $firebase = $factory->createFirestore()->database();

        $firebase->collection('tour_leaders')
            ->document((string) $user->id)
            ->collection('orders')
            ->document((string) $order->id)
            ->set($firestoreData);
        $notifier = new SendNotificationHelper();
        if ($categoryIds->isNotEmpty()) {

            User::where('type', UserType::SUPPLIER)
                ->whereIn('category_excursion_id', $categoryIds)
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
        }

        return $order;
    }

}

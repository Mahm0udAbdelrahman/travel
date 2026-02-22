<?php
namespace App\Services\Api\Supplier;

use App\Helpers\SendNotificationHelper;
use App\Models\Excursion;
use App\Models\Order;
use Kreait\Firebase\Factory;

class OrderService
{
    public function __construct(public Order $model)
    {}

    public function index()
    {
        $userId = auth()->id();

        $orders = $this->model
            ->with('orderable')
            ->whereHasMorph('orderable', [Excursion::class], function ($q) {
                $q->where('category_excursion_id', auth()->user()->category_excursion_id);
            })
            ->whereDoesntHave('orderStatuses', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('status', 'rejected');
            })
            ->whereDoesntHave('orderStatuses', function ($q) use ($userId) {
                $q->where('status', 'accepted')
                    ->where('user_id', '!=', $userId);
            })
            ->latest()
            ->paginate();

        return $orders;
    }

    // public function updateOrderStatus($id, $data)
    // {
    //     $order = $this->model->findOrFail($id);

    //     $exists = $order->orderStatuses()
    //         ->where('user_id', auth()->id())
    //         ->where('status', $data['status'])
    //         ->exists();

    //     if ($exists) {
    //         return response()->json([
    //             'status'  => 'exists',
    //             'message' => 'أنت بالفعل وافقت على هذا الطلب.',
    //         ]);
    //     }

    //     $order->orderStatuses()->updateOrCreate(
    //         [
    //             'user_id' => auth()->id(),
    //         ], [
    //             'status' => $data['status'],
    //         ]
    //     );
    //     $supplierName = $order->orderStatuses()->where('status', 'accepted')->first()->user->name ?? 'المورد';
    //     if ($data['status'] === 'accepted') {
    //         $notificationData = [
    //             'title_en' => 'Order Approved',
    //             'body_en'  => "Your trip has been approved by {$supplierName}.",

    //             'title_ar' => 'تمت الموافقة على الرحلة',
    //             'body_ar'  => "تمّت الموافقة على رحلتك من قبل {$supplierName}.",

    //         ];

    //         $sendNotificationHelper = new SendNotificationHelper();
    //         $sendNotificationHelper->sendNotification($notificationData, [$order->user->fcm_token ?? null]);

    //     }

    //     return $order;
    // }

    public function updateOrderStatus($id, $data)
    {
        $order = $this->model->with(['user', 'orderable'])->findOrFail($id);

        $exists = $order->orderStatuses()
            ->where('user_id', auth()->id())
            ->where('status', $data['status'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'exists',
                'message' => 'أنت بالفعل وافقت على هذا الطلب.',
            ]);
        }

        $order->orderStatuses()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                'status' => $data['status'],
            ]
        );

        $order->update(['status' => $data['status']]);

        if ($data['status'] === 'completed') {
            $this->removeOrderFromFirestore($order);
        }

        $supplierName = auth()->user()->name ?? 'المورد';

        if ($data['status'] === 'accepted') {

            $notificationData = [
                'title_en' => 'Order Approved',
                'body_en'  => "Your trip has been approved by {$supplierName}.",

                'title_ar' => 'تمت الموافقة على الرحلة',
                'body_ar'  => "تمّت الموافقة على رحلتك من قبل {$supplierName}.",
            ];

            if (! empty($order->user?->fcm_token)) {
                $sendNotificationHelper = new SendNotificationHelper();
                $sendNotificationHelper->sendNotification(
                    $notificationData,
                    [$order->user->fcm_token]
                );
            }

            $factory = (new Factory)
                ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));

            $db = $factory->createFirestore()->database();

            $firestoreOrderData = [
                'id'                => $order->id,
                'user_id'           => $order->user->id,
                'user_name'         => $order->user->name,
                'user_phone'        => $order->user->phone,
                'hotel_id'          => $order->hotel_id ?? null,
                'hotel_name'        => $order->hotel_name ?? null,
                'category_name'     => $order->orderable?->category?->name ?? null,
                'sub_category_name' => $order->orderable?->subCategory?->name ?? null,
                'image'             => $order->orderable?->image ?? null,
                'room_number'       => $order->room_number ?? null,
                'orderable_id'      => $order->orderable_id,
                'orderable_type'    => $order->orderable_type,
                'quantity'          => $order->quantity ?? 1,
                'order_number'      => $order->order_number,
                'date'              => $order->date,
                'time'              => $order->time ?? null,
                'type'              => $order->type ?? 'normal',
                'notes'             => $order->notes ?? null,
                'price'             => $order->price,
                'status'            => $order->status,
                'payment_method'    => $order->payment_method,
                'payment_status'    => $order->payment_status,
                'is_tour_leader'    => $order->is_tour_leader ?? 0,
                'created_at'        => $order->created_at,
                'updated_at'        => now(),
            ];

            $db->collection('customers')
                ->document((string) auth()->id())
                ->collection('orders')
                ->document((string) $order->id)
                ->set($firestoreOrderData, ['merge' => true]);
        }

        return $order;
    }

    private function removeOrderFromFirestore(Order $order): void
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));

        $db = $factory->createFirestore()->database();

        /* =======================
     |  1️⃣ Remove from Supplier
     ======================= */
        $db->collection('supplier')
            ->document((string) auth()->id())
            ->collection('orders')
            ->document((string) $order->id)
            ->delete();

        /* =======================
     |  2️⃣ Remove from Customer
     ======================= */
        $db->collection('customers')
            ->document((string) $order->user_id)
            ->collection('orders')
            ->document((string) $order->id)
            ->delete();

        /* =======================
     |  3️⃣ Remove from Tour Leaders
     ======================= */
        $tourLeaders = $order->hotel?->tourLeaders ?? collect();

        foreach ($tourLeaders as $tourLeader) {
            $db->collection('tour_leaders')
                ->document((string) $tourLeader->id)
                ->collection('orders')
                ->document((string) $order->id)
                ->delete();
        }
    }
}

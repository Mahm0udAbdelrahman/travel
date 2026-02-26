<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\UserType;
use App\Helpers\SendNotificationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Order\OrderRequest;
use App\Http\Requests\Api\User\Order\OrderUpdateRequest;
use App\Http\Resources\User\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Notifications\DashboardNotification;
use App\Services\Api\User\OrderService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Kreait\Firebase\Factory;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $orderService) {}
    public function store(OrderRequest $orderRequest)
    {

        $method = $orderRequest->payment_method == 'cash' ? 'cashOrder' : 'store';
        return $this->orderService->$method($orderRequest->validated());
    }

    public function update($id, OrderUpdateRequest $orderUpdateRequest)
    {
        $this->orderService->update($id, $orderUpdateRequest->validated());
        return $this->okResponse([], 'Update Order successfully');
    }

    //     public function handle(Request $request)
    //     {
    //         $payload   = $request->getContent();
    //         $sigHeader = $request->header('Stripe-Signature');
    //         $secret    = config('services.stripe.webhook_secret');

    //         try {
    //             $event = Webhook::constructEvent(
    //                 $payload,
    //                 $sigHeader,
    //                 $secret
    //             );
    //         } catch (SignatureVerificationException $e) {
    //             Log::error('Stripe Webhook Signature Error', [
    //                 'error' => $e->getMessage(),
    //             ]);
    //             return response()->json(['error' => 'Invalid signature'], 400);
    //         } catch (\Exception $e) {
    //             Log::error('Stripe Webhook Error', [
    //                 'error' => $e->getMessage(),
    //             ]);
    //             return response()->json(['error' => 'Invalid payload'], 400);
    //         }

    //         if ($event->type === 'checkout.session.completed') {

    //             $session = $event->data->object;

    //             $order = Order::where('payment_id', $session->id)->first();

    //             if ($order) {
    //                 $order->update([
    //                     'payment_status' => 'paid',
    //                     'status'         => 'completed',
    //                 ]);
    //             }

    //             $categoryIds = collect();

    // /**
    //  * Determine supplier categories
    //  */
    //             if ($order->orderable_type === 'App\Models\Excursion') {

    //                 $categoryIds = collect([$order->orderable->category_excursion_id]);

    //             } elseif ($order->orderable_type === 'App\Models\Offer') {

    //                 $categoryIds = DB::table('excursion_offers')
    //                     ->join('excursions', 'excursions.id', '=', 'excursion_offers.excursion_id')
    //                     ->where('excursion_offers.offer_id', $order->orderable->id)
    //                     ->pluck('excursions.category_excursion_id')
    //                     ->unique();
    //             }

    //             $factory = (new Factory)
    //                 ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));

    //             $db = $factory->createFirestore()->database();

    //             $sendNotificationHelper = new SendNotificationHelper();

    //             $firestoreOrderData = [
    //                 'id'                => $order->id,
    //                 'order_number'      => $order->order_number,
    //                 'customer_id'       => $order->user->id,
    //                 'customer_name'     => $order->user->name,
    //                 'customer_phone'    => $order->user->phone,
    //                 'hotel_id'          => $order->hotel_id,
    //                 'hotel_name'        => $order->hotel?->name[app()->getLocale()] ?? null,
    //                 'category_name'     => $order->orderable?->categoryExcursion?->name[app()->getLocale()] ?? null,
    //                 'sub_category_name' => $order->orderable?->subcategoryExcursion?->name[app()->getLocale()] ?? null,
    //                 'image'             => $order->orderable?->image ?? null,
    //                 'room_number'       => $order->room_number,
    //                 'orderable_id'      => $order->orderable?->id,
    //                 'orderable_type'    => $order->orderable_type,
    //                 'quantity'          => $order->quantity,
    //                 'date'              => $order->date ?? now(),
    //                 'excursion_name'    => $order->orderable?->name[app()->getLocale()] ?? null,
    //                 'time'              => $order->time,
    //                 'type'              => $order->type ?? 'normal',
    //                 'notes'             => $order->notes,
    //                 'price'             => $order->price,
    //                 'is_tour_leader'    => $order->is_tour_leader,
    //                 'status'            => 'pending',
    //                 'payment_method'    => 'card',
    //                 'payment_status'    => 'paid',
    //                 'created_at'        => now(),
    //                 'updated_at'        => now(),
    //             ];

    //             $db->collection('customers')
    //                 ->document($order->user->id)
    //                 ->collection('orders')
    //                 ->document((string) $order->id)
    //                 ->set($firestoreOrderData);

    //             $tourLeaders = $order->hotel?->tourLeaders ?? collect();

    //             foreach ($tourLeaders as $tourLeader) {

    //                 if (! empty($tourLeader->fcm_token)) {
    //                     $sendNotificationHelper->sendNotification([
    //                         'title_en' => 'New Order',
    //                         'body_en'  => 'A new order assigned to your hotel',
    //                         'title_ar' => 'طلب جديد',
    //                         'body_ar'  => 'تم إضافة طلب جديد مرتبط بالفندق',
    //                         'order_id' => $order->id,
    //                     ], [$tourLeader->fcm_token]);
    //                 }

    //                 $db->collection('tour_leaders')
    //                     ->document($tourLeader->id)
    //                     ->collection('orders')
    //                     ->document((string) $order->id)
    //                     ->set($firestoreOrderData);
    //             }

    //             if ($categoryIds->isNotEmpty()) {

    //                 User::where('type', UserType::SUPPLIER)
    //                     ->whereIn('category_excursion_id', $categoryIds)
    //                     ->chunk(100, function ($suppliers) use ($db, $firestoreOrderData, $sendNotificationHelper, $order) {

    //                         foreach ($suppliers as $supplier) {

    //                             if ($supplier->fcm_token) {
    //                                 $sendNotificationHelper->sendNotification([
    //                                     'title_en' => 'New Order Received',
    //                                     'body_en'  => 'You have a new order',
    //                                     'title_ar' => 'طلب جديد',
    //                                     'body_ar'  => 'لديك طلب جديد',
    //                                     'order_id' => $order->id,
    //                                 ], [$supplier->fcm_token]);
    //                             }

    //                             $db->collection('suppliers')
    //                                 ->document((string) $supplier->id)
    //                                 ->collection('orders')
    //                                 ->document((string) $order->id)
    //                                 ->set($firestoreOrderData);
    //                         }
    //                     });
    //             }

    //             $adminUsers = User::whereHas('roles', function ($query) {
    //                 $query->where('name', 'admin');
    //             })->get();
    //             Notification::send(
    //                 $adminUsers,
    //                 new DashboardNotification($order->id, $order->user->name, $order->price, 'order')
    //             );
    //         }

    //         if ($event->type === 'payment_intent.payment_failed') {
    //             $intent = $event->data->object;

    //             Order::where('payment_id', $intent->id)->update([
    //                 'payment_status' => 'failed',
    //                 'status'         => 'cancelled',
    //             ]);
    //         }

    //         return response()->json(['status' => 'success']);
    //     }

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

            $categoryIds    = collect();
            $subCategoryIds = collect();

            /**
             * Determine supplier categories & sub categories
             */
            if ($order->orderable_type === 'App\Models\Excursion') {

                $categoryIds    = collect([$order->orderable->category_excursion_id]);
                $subCategoryIds = collect([$order->orderable->sub_category_excursion_id]);
            } elseif ($order->orderable_type === 'App\Models\Offer') {

                $excursions = DB::table('excursion_offers')
                    ->join('excursions', 'excursions.id', '=', 'excursion_offers.excursion_id')
                    ->where('excursion_offers.offer_id', $order->orderable->id)
                    ->select(
                        'excursions.category_excursion_id',
                        'excursions.sub_category_excursion_id'
                    )
                    ->get();

                $categoryIds    = $excursions->pluck('category_excursion_id')->unique();
                $subCategoryIds = $excursions->pluck('sub_category_excursion_id')->unique();
            }

            $factory = (new Factory)
                ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));

            $db = $factory->createFirestore()->database();

            $sendNotificationHelper = new SendNotificationHelper();

            $firestoreOrderData = [
                'id'                => $order->id,
                'order_number'      => $order->order_number,
                'customer_id'       => $order->user->id,
                'customer_name'     => $order->user->name,
                'customer_phone'    => $order->user->phone,
                'hotel_id'          => $order->hotel_id,
                'hotel_name'        => $order->hotel?->name[app()->getLocale()] ?? null,
                'category_name'     => $order->orderable?->categoryExcursion?->name[app()->getLocale()] ?? null,
                'sub_category_name' => $order->orderable?->subcategoryExcursion?->name[app()->getLocale()] ?? null,
                'image'             => $order->orderable?->image ?? null,
                'room_number'       => $order->room_number,
                'orderable_id'      => $order->orderable?->id,
                'orderable_type'    => $order->orderable_type,
                'quantity'          => $order->quantity,
                'date'              => $order->date ?? now(),
                'excursion_name'    => $order->orderable?->name[app()->getLocale()] ?? null,
                'time'              => $order->time,
                'type'              => $order->type ?? 'normal',
                'notes'             => $order->notes,
                'price'             => $order->price,
                'is_tour_leader'    => $order->is_tour_leader,
                'status'            => 'pending',
                'payment_method'    => 'card',
                'payment_status'    => 'paid',
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            $db->collection('customers')
                ->document((string) $order->user->id)
                ->collection('orders')
                ->document((string) $order->id)
                ->set($firestoreOrderData);

            $tourLeaders = $order->hotel?->tourLeaders ?? collect();

            foreach ($tourLeaders as $tourLeader) {

                if (!empty($tourLeader->fcm_token)) {
                    $sendNotificationHelper->sendNotification([
                        'title_en' => 'New Order',
                        'body_en'  => 'A new order assigned to your hotel',
                        'title_ar' => 'طلب جديد',
                        'body_ar'  => 'تم إضافة طلب جديد مرتبط بالفندق',
                        'order_id' => $order->id,
                    ], [$tourLeader->fcm_token]);
                }

                $db->collection('tour_leaders')
                    ->document((string) $tourLeader->id)
                    ->collection('orders')
                    ->document((string) $order->id)
                    ->set($firestoreOrderData);
            }

            /**
             * Send order to suppliers by category OR sub category
             */
            if ($categoryIds->isNotEmpty() || $subCategoryIds->isNotEmpty()) {

                User::where('type', UserType::SUPPLIER)
                    ->where(function ($q) use ($categoryIds, $subCategoryIds) {
                        if ($categoryIds->isNotEmpty()) {
                            $q->whereIn('category_excursion_id', $categoryIds);
                        }

                        if ($subCategoryIds->isNotEmpty()) {
                            $q->orWhereIn('sub_category_excursion_id', $subCategoryIds);
                        }
                    })
                    ->chunk(100, function ($suppliers) use ($db, $firestoreOrderData, $sendNotificationHelper, $order) {

                        foreach ($suppliers as $supplier) {

                            if ($supplier->fcm_token) {
                                $sendNotificationHelper->sendNotification([
                                    'title_en' => 'New Order Received',
                                    'body_en'  => 'You have a new order',
                                    'title_ar' => 'طلب جديد',
                                    'body_ar'  => 'لديك طلب جديد',
                                    'order_id' => $order->id,
                                ], [$supplier->fcm_token]);
                            }

                            $db->collection('suppliers')
                                ->document((string) $supplier->id)
                                ->collection('orders')
                                ->document((string) $order->id)
                                ->set($firestoreOrderData);
                        }
                    });
            }

            $adminUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();

            Notification::send(
                $adminUsers,
                new DashboardNotification(
                    $order->id,
                    $order->user->name,
                    $order->price,
                    'order'
                )
            );
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

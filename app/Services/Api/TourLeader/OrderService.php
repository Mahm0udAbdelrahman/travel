<?php
namespace App\Services\Api\TourLeader;

use App\Models\Order;
use Illuminate\Support\Str;

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
            'is_tour_leader' => 1
        ]);
    }

}

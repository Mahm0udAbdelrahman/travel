<?php
namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $map = [
            'real_estate'        => \App\Models\RealEstate::class,
            'event'              => \App\Models\Event::class,
            'excursion'          => \App\Models\Excursion::class,
            'offer'              => \App\Models\Offer::class,
            'additional_service' => \App\Models\AdditionalService::class,
        ];

        $reverseMap = array_flip($map);
        return [
            'id'                => $this->id,
            'user_id'           => $this->user_id,
            'user_name'         => $this->user->name,
            'user_phone'        => $this->user->phone,
            'hotel_id'          => $this->hotel_id,
            'hotel_name'        => $this->hotel->name[app()->getLocale()] ?? null,
            'category_name'     => $this->orderable->categoryExcursion->name[app()->getLocale()] ?? null,
            'sub_category_name' => $this->orderable->subcategoryExcursion->name[app()->getLocale()] ?? null,
            'image'             => $this->orderable->image ?? null,
            'room_number'       => $this->room_number,
            'orderable_id'      => $this->orderable_id,
            'orderable_type'    => $reverseMap[$this->orderable_type] ?? $this->orderable_type,
            'quantity'          => $this->quantity,
            'order_number'      => $this->order_number,
            'date'              => $this->date,
            'time'              => $this->time,
            'type'              => $this->type,
            'notes'             => $this->notes,
            'price'             => $this->price,
            'status'            => $this->status,
            'payment_method'    => $this->payment_method,
            'payment_status'    => $this->payment_status,
            'is_tour_leader'    => $this->is_tour_leader,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}

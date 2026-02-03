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
        return [
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'hotel_id'       => $this->hotel_id,
            'hotel_name'     => $this->hotel->name[app()->getLocale()] ?? null,
            'room_number'    => $this->room_number,
            'orderable_id'   => $this->orderable_id,
            'orderable_type' => $this->orderable_type,
            'quantity'       => $this->quantity,
            'order_number'   => $this->order_number,
            'date'           => $this->date,
            'time'           => $this->time,
            'type'           => $this->type,
            'notes'          => $this->notes,
            'price'          => $this->price,
            'status'         => $this->status,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,

        ];
    }
}

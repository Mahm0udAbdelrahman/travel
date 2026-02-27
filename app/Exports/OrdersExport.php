<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Order No',
            'User Name',
            'User Type',
            'Hotel',
            'Service Type',
            'Service Name',
            'Date',
            'Price',
            'Status',
        ];
    }

    public function map($order): array
    {
        $types = [
            \App\Models\Excursion::class => 'Excursion',
            \App\Models\RealEstate::class => 'Real Estate',
            \App\Models\Event::class => 'Event',
            \App\Models\AdditionalService::class => 'Additional Service',
        ];

        return [
            $order->order_number,
            $order->user?->name,
            $order->user?->type?->label(),
            $order->hotel?->name['en'] ?? '-',
            $types[$order->orderable_type] ?? 'Unknown',
            $order->orderable?->name['en'] ?? '-',
            $order->date,
            number_format($order->price, 2),
            $order->lastStatus?->status ?? '-',
        ];
    }
}

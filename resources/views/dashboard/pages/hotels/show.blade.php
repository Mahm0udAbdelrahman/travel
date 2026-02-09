@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- عنوان الفندق -->
        <h3>{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h3>

        <!-- حالة الفندق -->
        <p>
            <span class="badge {{ $hotel->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $hotel->is_active ? __('Active') : __('Inactive') }}
            </span>
        </p>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="ordersTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab">
                    {{ __('Today') }} ({{ $ordersByPeriod['today']->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="yesterday-tab" data-bs-toggle="tab" data-bs-target="#yesterday" type="button" role="tab">
                    {{ __('Yesterday') }} ({{ $ordersByPeriod['yesterday']->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="day_before_yesterday-tab" data-bs-toggle="tab" data-bs-target="#day_before_yesterday" type="button" role="tab">
                    {{ __('Day Before Yesterday') }} ({{ $ordersByPeriod['day_before_yesterday']->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tomorrow-tab" data-bs-toggle="tab" data-bs-target="#tomorrow" type="button" role="tab">
                    {{ __('Tomorrow') }} ({{ $ordersByPeriod['tomorrow']->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="day_after_tomorrow-tab" data-bs-toggle="tab" data-bs-target="#day_after_tomorrow" type="button" role="tab">
                    {{ __('Day After Tomorrow') }} ({{ $ordersByPeriod['day_after_tomorrow']->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                    {{ __('All Orders') }} ({{ $ordersByPeriod['all']->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="ordersTabsContent">
            @foreach ($ordersByPeriod as $period => $orders)
                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $period }}" role="tabpanel">
                    @if($orders->isEmpty())
                        <p class="text-muted fst-italic">{{ __('No orders found.') }}</p>
                    @else
                        <ul class="list-group">
                            @foreach ($orders as $order)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $order->order_number }}</strong> - {{ $order->type }}<br>
                                        <small>{{ __('Quantity') }}: {{ $order->quantity }}</small><br>
                                        <small>{{ __('Date') }}: {{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</small>
                                    </div>
                                    <span class="badge bg-info">{{ $order->status }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 text-primary fw-bold">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h3>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-hotel me-1"></i> {{ __('Hotel Dashboard & Daily Schedule') }}
                        </p>
                    </div>
                    <div>
                        <span class="badge rounded-pill p-2 px-3 {{ $hotel->is_active ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} border">
                            <i class="fas fa-circle f-10 me-1"></i>
                            {{ $hotel->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-user-tie me-2 text-primary"></i>{{ __('Tour Leaders') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($tourLeaders as $leader)
                                <div class="list-group-item d-flex align-items-center py-3 border-0 border-bottom">
                                    <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                        {{ strtoupper(substr($leader->name, 0, 1)) }}
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold small">{{ $leader->name }}</h6>
                                        <small class="text-muted d-block f-10"><i class="fas fa-phone-alt me-1"></i> {{ $leader->phone }}</small>
                                    </div>
                                    <a href="tel:{{ $leader->phone }}" class="ms-auto btn btn-sm btn-link text-primary p-0">
                                        <i class="fas fa-phone-volume"></i>
                                    </a>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <small class="text-muted fst-italic">{{ __('No Tour Leaders assigned') }}</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h6 class="text-muted small fw-bold text-uppercase mb-3">{{ __('Select Schedule Date') }}</h6>
                        <div class="nav nav-pills d-flex flex-nowrap overflow-auto scrollbar-hidden pb-3 gap-2" id="v-pills-tab" role="tablist">
                            @foreach($ordersByDate as $date => $orders)
                                @php
                                    $carbonDate = \Carbon\Carbon::parse($date);
                                    $isToday = $carbonDate->isToday();
                                @endphp
                                <button class="nav-link date-pill border d-flex flex-column align-items-center justify-content-center @if($loop->first) active @endif"
                                        id="tab-{{ $date }}"
                                        data-bs-toggle="pill"
                                        data-bs-target="#content-{{ $date }}"
                                        role="tab">
                                    <span class="day-name">{{ $carbonDate->format('D') }}</span>
                                    <span class="day-number">{{ $carbonDate->format('d') }}</span>
                                    <span class="month-name">{{ $carbonDate->format('M') }}</span>
                                    @if($isToday)
                                        <span class="today-dot"></span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-body bg-light-secondary-soft mt-2">
                        <div class="tab-content" id="v-pills-tabContent">
                            @forelse($ordersByDate as $date => $orders)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="content-{{ $date }}" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            <i class="far fa-calendar-check me-2 text-primary"></i>
                                            {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                                        </h5>
                                        <span class="badge bg-primary rounded-pill">{{ $orders->count() }} {{ __('Orders') }}</span>
                                    </div>

                                    <div class="row g-3">
                                        @foreach($orders as $order)
                                            <div class="col-md-6 col-xxl-4">
                                                <div class="card border shadow-none mb-0 h-100 trip-card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <div class="avtar avtar-s {{ $order->status == 'completed' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }} rounded-circle">
                                                                <i class="fas {{ $order->orderable_type == 'App\Models\Excursion' ? 'fa-shuttle-van' : 'fa-clipboard-list' }}"></i>
                                                            </div>
                                                            <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }} f-10">
                                                                {{ strtoupper($order->status) }}
                                                            </span>
                                                        </div>

                                                        <h6 class="mb-1 fw-bold text-truncate">{{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}</h6>
                                                        <p class="text-primary small mb-3 fw-medium">#{{ $order->order_number }}</p>

                                                        <div class="p-2 bg-light rounded-3 mb-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-muted small">{{ __('Guest') }}:</span>
                                                                <span class="small fw-bold text-dark">{{ \Illuminate\Support\Str::limit($order->user->name, 15) }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted small">{{ __('Room') }}:</span>
                                                                <span class="small fw-bold">{{ $order->room_number }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                                            <span class="text-muted f-10"><i class="fas fa-users me-1"></i> {{ $order->quantity }}</span>
                                                            <span class="text-muted f-10"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-light mb-3"></i>
                                    <p class="text-muted">{{ __('No orders available for this hotel.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* تحسينات شريط التقويم */
    .scrollbar-hidden::-webkit-scrollbar { display: none; }
    .scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }

    .date-pill {
        min-width: 65px;
        height: 80px;
        background: #fff;
        border: 1px solid #eee !important;
        border-radius: 12px;
        color: #666;
        transition: all 0.2s ease-in-out;
        position: relative;
    }

    .date-pill .day-name { font-size: 10px; text-uppercase; opacity: 0.7; }
    .date-pill .day-number { font-size: 1.2rem; fw-bold; margin: 2px 0; }
    .date-pill .month-name { font-size: 10px; fw-medium; }

    .date-pill.active {
        background: var(--bs-primary) !important;
        color: #fff !important;
        border-color: var(--bs-primary) !important;
        box-shadow: 0 8px 15px rgba(var(--bs-primary-rgb), 0.25);
        transform: translateY(-3px);
    }

    .today-dot {
        position: absolute;
        bottom: 5px;
        width: 4px;
        height: 4px;
        background: #fff;
        border-radius: 50%;
    }

    /* تحسين بطاقة الرحلة */
    .trip-card { transition: 0.3s; cursor: default; }
    .trip-card:hover {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
    }

    .bg-light-secondary-soft { background-color: #fcfcfd; }
    .avtar-s { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
    .f-10 { font-size: 10px; }
</style>
@endsection

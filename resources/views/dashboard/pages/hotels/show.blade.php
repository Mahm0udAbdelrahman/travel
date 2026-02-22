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
                            <i class="fas fa-map-marker-alt me-1"></i> {{ __('Hotel Management & Orders History') }}
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
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary text-primary me-2">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5 class="mb-0">{{ __('Tour Leaders') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($tourLeaders as $leader)
                                <div class="list-group-item d-flex align-items-center py-3 border-0 border-bottom">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                            {{ strtoupper(substr($leader->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold">{{ $leader->name }}</h6>
                                        <small class="text-muted"><i class="fas fa-phone-alt me-1 f-10"></i> {{ $leader->phone }}</small>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="tel:{{ $leader->phone }}" class="btn btn-sm btn-light-primary rounded-circle">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0 fst-italic">{{ __('No Tour Leaders assigned.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-stream me-2 text-primary"></i>{{ __('Orders History') }}
                        </h5>
                        <div class="dropdown">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $allOrders->count() }} {{ __('Total Orders') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="timeline-container">
                            @forelse ($allOrders as $order)
                                <div class="timeline-item d-flex mb-4">
                                    <div class="timeline-date text-end pe-3 d-none d-sm-block">
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->date)->format('d M') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($order->date)->format('Y') }}</small>
                                    </div>

                                    <div class="timeline-status me-3 position-relative">
                                        <div class="timeline-line"></div>
                                        <div class="timeline-dot shadow-sm {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            <i class="fas {{ $order->orderable_type == 'App\Models\Excursion' ? 'fa-bus-alt' : 'fa-concierge-bell' }} text-white f-10"></i>
                                        </div>
                                    </div>

                                    <div class="timeline-content flex-grow-1 card border shadow-none bg-light-gray mb-0">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                                <div class="mb-2">
                                                    <h6 class="mb-1 fw-bold text-primary">
                                                        {{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}
                                                    </h6>
                                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                                        <span class="badge bg-white text-dark border f-10">#{{ $order->order_number }}</span>
                                                        <span class="text-muted f-12 d-sm-none">
                                                            <i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($order->date)->format('d M, Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-sm-end mb-2">
                                                    <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }} rounded-pill">
                                                        {{ strtoupper($order->status) }}
                                                    </span>
                                                    <small class="d-block text-muted mt-1">{{ \Carbon\Carbon::parse($order->date)->diffForHumans() }}</small>
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 avatar avatar-xs bg-light-secondary rounded-circle">
                                                        <i class="fas fa-user text-secondary f-10"></i>
                                                    </div>
                                                    <div class="ms-2">
                                                        <span class="d-block fw-medium text-dark f-12">{{ $order->user->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-3">
                                                    <div class="text-center">
                                                        <small class="text-muted d-block f-10">{{ __('Room') }}</small>
                                                        <span class="fw-bold">{{ $order->room_number }}</span>
                                                    </div>
                                                    <div class="text-center">
                                                        <small class="text-muted d-block f-10">{{ __('Quantity') }}</small>
                                                        <span class="fw-bold">{{ $order->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
                                    <p class="text-muted fst-italic">{{ __('No orders history for this hotel yet.') }}</p>
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
    /* Custom Timeline CSS */
    .timeline-container { position: relative; padding: 10px 0; }
    .timeline-date { min-width: 70px; }
    .timeline-status { width: 40px; }
    .timeline-line {
        position: absolute;
        width: 2px;
        background-color: #f1f1f1;
        top: 30px;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }
    .timeline-item:last-child .timeline-line { display: none; }
    .timeline-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        border: 4px solid #fff;
    }
    .bg-light-gray { background-color: #f9f9fb; transition: all 0.2s ease-in-out; }
    .timeline-content:hover {
        background-color: #fff;
        border-color: var(--bs-primary) !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.07) !important;
        transform: translateY(-2px);
    }
    .avatar-xs { width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; }
    .f-10 { font-size: 10px; }
    .f-12 { font-size: 12px; }
    .avtar-s { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>
@endsection

@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="fw-bold text-primary">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-user-tie me-2"></i>{{ __('Tour Leaders') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($tourLeaders as $leader)
                            <div class="p-3 border-bottom d-flex align-items-center">
                                <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                    {{ strtoupper(substr($leader->name, 0, 1)) }}
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 small fw-bold">{{ $leader->name }}</h6>
                                    <small class="text-muted f-10">{{ $leader->phone }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted small">{{ __('No leaders assigned') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h6 class="text-muted small fw-bold text-uppercase mb-3">{{ __('Select Schedule Date') }}</h6>

                        <div class="nav nav-pills d-flex flex-nowrap overflow-auto scrollbar-hidden pb-3 gap-3" id="pills-tab" role="tablist">
                            @foreach($ordersByDate as $date => $orders)
                                @php $carbonDate = \Carbon\Carbon::parse($date); @endphp
                                <button class="nav-link date-item @if($loop->first) active @endif"
                                        id="tab-{{ $date }}"
                                        data-bs-toggle="pill"
                                        data-bs-target="#content-{{ $date }}"
                                        type="button" role="tab">
                                    <span class="d-block small opacity-75">{{ $carbonDate->format('D') }}</span>
                                    <span class="d-block fs-3 fw-bold my-1">{{ $carbonDate->format('d') }}</span>
                                    <span class="d-block small fw-medium">{{ $carbonDate->format('M') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-body bg-light-gray-soft">
                        <div class="tab-content" id="pills-tabContent">
                            @foreach($ordersByDate as $date => $orders)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="content-{{ $date }}" role="tabpanel">
                                    <div class="row g-3">
                                        @foreach($orders as $order)
                                            <div class="col-md-6 col-xxl-4">
                                                <div class="card border shadow-none trip-card h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between mb-3">
                                                            <div class="avtar avtar-s {{ $order->status == 'completed' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }} rounded-circle">
                                                                <i class="fas {{ $order->orderable_type == 'App\Models\Excursion' ? 'fa-shuttle-van' : 'fa-clipboard-list' }}"></i>
                                                            </div>
                                                            <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }} f-10 h-25">
                                                                {{ strtoupper($order->status) }}
                                                            </span>
                                                        </div>

                                                        <h6 class="mb-1 fw-bold text-primary">{{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}</h6>
                                                        <p class="text-muted small mb-3">#{{ $order->order_number }}</p>

                                                        <div class="bg-light p-2 rounded mb-3">
                                                            <div class="d-flex justify-content-between small mb-1">
                                                                <span class="text-muted">{{ __('Guest') }}:</span>
                                                                <span class="fw-bold">{{ $order->user->name }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between small">
                                                                <span class="text-muted">{{ __('Room') }}:</span>
                                                                <span class="fw-bold">{{ $order->room_number }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center f-10 text-muted border-top pt-2">
                                                            <span><i class="fas fa-users me-1"></i> {{ $order->quantity }}</span>
                                                            <span><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($order->date)->format('h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .scrollbar-hidden::-webkit-scrollbar { display: none; }
    .scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }

    /* Calendar Item Style */
    .date-item {
        min-width: 75px;
        height: 95px;
        background: #fff;
        border: 1px solid #eee !important;
        border-radius: 12px;
        color: #444;
        transition: 0.3s ease;
    }
    .date-item.active {
        background: #0d6efd !important; /* لون أزرق مثل الصورة */
        color: #fff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        transform: translateY(-5px);
    }

    .trip-card { transition: 0.2s; border-radius: 12px; }
    .trip-card:hover { border-color: #0d6efd; transform: translateY(-3px); }
    .bg-light-gray-soft { background-color: #f8f9fa; }
    .f-10 { font-size: 10px; }
</style>
@endsection

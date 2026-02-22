@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-12">
                <h3 class="mb-1 text-primary fw-bold">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h3>
                <span class="badge rounded-pill {{ $hotel->is_active ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} border">
                    {{ $hotel->is_active ? __('Active') : __('Inactive') }}
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0"><i class="fas fa-user-tie me-2 text-primary"></i>{{ __('Tour Leaders') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($tourLeaders as $leader)
                            <div class="p-3 border-bottom d-flex align-items-center">
                                <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                    {{ substr($leader->name, 0, 1) }}
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 small fw-bold">{{ $leader->name }}</h6>
                                    <small class="text-muted f-10">{{ $leader->phone }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-3 text-muted mb-0 small fst-italic">{{ __('No Leaders') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white p-0">
                        <ul class="nav nav-pills nav-fill flex-nowrap overflow-auto scrollbar-hidden" id="dateTabs" role="tablist" style="background: #f8f9fa;">
                            @forelse($ordersByDate as $date => $orders)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-3 @if($loop->first) active @endif"
                                            id="tab-{{ $date }}" data-bs-toggle="tab"
                                            data-bs-target="#content-{{ $date }}" type="button" role="tab">
                                        <span class="d-block fw-bold small text-uppercase">{{ \Carbon\Carbon::parse($date)->format('d M') }}</span>
                                        <span class="badge bg-secondary rounded-pill f-10">{{ $orders->count() }}</span>
                                    </button>
                                </li>
                            @empty
                                <li class="nav-item p-3 text-muted">{{ __('No Orders Found') }}</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            @foreach($ordersByDate as $date => $orders)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="content-{{ $date }}" role="tabpanel">
                                    <div class="timeline-simple">
                                        @foreach($orders as $order)
                                            <div class="card border shadow-none bg-light-gray mb-3">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s {{ $order->status == 'completed' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }} me-3">
                                                                <i class="fas {{ $order->orderable_type == 'App\Models\Excursion' ? 'fa-bus' : 'fa-concierge-bell' }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">{{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}</h6>
                                                                <small class="text-primary fw-medium">#{{ $order->order_number }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }} mb-1">
                                                                {{ strtoupper($order->status) }}
                                                            </span>
                                                            <div class="small text-muted"><i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($order->created_at)->format('H:i A') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-3 border-top d-flex gap-4">
                                                        <div class="small"><i class="far fa-user me-1 text-muted"></i> <strong>{{ $order->user->name }}</strong></div>
                                                        <div class="small"><i class="fas fa-door-open me-1 text-muted"></i> <strong>{{ $order->room_number }}</strong></div>
                                                        <div class="small"><i class="fas fa-users me-1 text-muted"></i> <strong>{{ $order->quantity }}</strong></div>
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
    /* اخفاء الشريط الجانبي للـ Tabs عند الكثرة */
    .scrollbar-hidden::-webkit-scrollbar { display: none; }
    .scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }

    .nav-pills .nav-link { border-radius: 0; color: #555; border-bottom: 3px solid transparent; transition: 0.3s; }
    .nav-pills .nav-link.active { background: #fff !important; color: var(--bs-primary) !important; border-bottom-color: var(--bs-primary); }

    .bg-light-gray { background-color: #f9f9fb; }
    .avtar-s { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
    .f-10 { font-size: 10px; }
</style>
@endsection

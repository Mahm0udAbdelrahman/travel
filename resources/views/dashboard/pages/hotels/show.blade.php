@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="mb-1 text-primary">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h3>
                <p class="mb-0">
                    <span class="badge rounded-pill {{ $hotel->is_active ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }}">
                        <i class="fas fa-circle f-10 me-1"></i>
                        {{ $hotel->is_active ? __('Active') : __('Inactive') }}
                    </span>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-user-tie me-2 text-primary"></i>{{ __('Tour Leaders') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($tourLeaders as $leader)
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <div class="flex-shrink-0 avatar avatar-sm bg-light-info text-info rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ $leader->name }}</h6>
                                        <small class="text-muted"><i class="fas fa-phone-alt me-1 f-10"></i>{{ $leader->phone }}</small>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4 text-muted fst-italic">
                                    {{ __('No Tour Leaders assigned to this hotel.') }}
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ __('All Orders History') }}</h5>
                        <span class="badge bg-primary rounded-pill">{{ $allOrders->count() }}</span>
                    </div>

                    <div class="card-body">
                        @if ($allOrders->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">{{ __('No orders found.') }}</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="hotel-orders-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Order Details') }}</th>
                                            <th>{{ __('Guest') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allOrders as $order)
                                            <tr>
                                                <td class="text-nowrap">
                                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($order->date)->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-1">
                                                            <h6 class="mb-0 fs-14">{{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}</h6>
                                                            <small class="text-primary">#{{ $order->order_number }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">{{ $order->user->name }}</div>
                                                    <div class="small text-muted">R: {{ $order->room_number }} | Q: {{ $order->quantity }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $order->status == 'completed' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }} border">
                                                        {{ strtoupper($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-sm { width: 35px; height: 35px; }
    .bg-light-info { background-color: rgba(0, 184, 217, 0.1); }
    .fs-14 { font-size: 14px; }
    .bg-light-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-light-warning { background-color: rgba(255, 193, 7, 0.1); }
</style>
@endsection

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

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-0">
                <ul class="nav nav-pills nav-fill flex-nowrap overflow-auto" id="ordersTabs" role="tablist">
                    @foreach(['today', 'yesterday', 'day_before_yesterday', 'tomorrow', 'day_after_tomorrow', 'all'] as $period)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-3 @if($loop->first) active @endif"
                                id="{{ $period }}-tab" data-bs-toggle="tab"
                                data-bs-target="#{{ $period }}" type="button" role="tab"
                                style="border-radius: 0;">
                            <span class="d-block fw-bold">{{ __(\Illuminate\Support\Str::headline($period)) }}</span>
                            <span class="badge bg-secondary rounded-pill">{{ $ordersByPeriod[$period]->count() }}</span>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="ordersTabsContent">
                    @foreach ($ordersByPeriod as $period => $orders)
                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $period }}" role="tabpanel">
                            @if ($orders->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted fst-italic">{{ __('No orders found for this period.') }}</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-top-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ __('Order Details') }}</th>
                                                <th>{{ __('Guest Info') }}</th>
                                                <th>{{ __('Room') }}</th>
                                                <th>{{ __('Date & Qty') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 avatar avatar-sm bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-shopping-cart"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-0">{{ $order->orderable->name[app()->getLocale()] ?? 'N/A' }}</h6>
                                                                @if ($order->orderable_type == 'App\Models\Excursion')
                                                                    <small class="text-muted d-block">
                                                                        {{ $order->orderable->categoryExcursion->name[app()->getLocale()] }}
                                                                        <i class="fas fa-chevron-right f-10 mx-1"></i>
                                                                        {{ $order->orderable->subcategoryExcursion->name[app()->getLocale()] }}
                                                                    </small>
                                                                @endif
                                                                <small class="text-primary fw-bold">#{{ $order->order_number }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ $order->user->name }}</div>
                                                        <div class="text-muted small"><i class="fas fa-phone-alt f-12 me-1"></i> {{ $order->user->phone }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-dark text-dark border">
                                                            <i class="fas fa-door-open me-1"></i> {{ $order->room_number }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="small fw-bold text-nowrap">
                                                            <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}
                                                        </div>
                                                        <div class="small text-muted text-nowrap">
                                                            <i class="fas fa-layer-group me-1"></i> {{ __('Qty') }}: {{ $order->quantity }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* تحسينات بسيطة للتنسيق */
    .nav-pills .nav-link { color: #6c757d; border-bottom: 2px solid transparent; }
    .nav-pills .nav-link.active { background-color: transparent !important; color: #007bff !important; border-bottom: 2px solid #007bff; }
    .avatar-sm { width: 40px; height: 40px; }
    .bg-light-primary { background-color: rgba(0, 123, 255, 0.1); }
    .bg-light-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-light-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-light-dark { background-color: #f8f9fa; }
    .f-10 { font-size: 10px; }
    .f-12 { font-size: 12px; }
</style>
@endsection

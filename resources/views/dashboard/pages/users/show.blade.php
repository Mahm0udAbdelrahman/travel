@extends('dashboard.layouts.app')
@section('title', __('User Profile'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <div class="page-header mb-4">
            <div class="page-block d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">{{ __('User Profile') }}</h4>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.users.index') }}">{{ __('Users') }}</a></li>
                        <li class="breadcrumb-item text-muted">{{ $user->name }}</li>
                    </ul>
                </div>
                <a href="{{ route('Admin.users.index') }}" class="btn btn-light border shadow-sm btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Users') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm text-center p-4 mb-4">
                    <div class="card-body">
                        <div class="avatar-wrapper mb-3">
                            <div class="avatar-initials rounded-circle d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary fw-bold fs-1" style="width: 100px; height: 100px; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-3"><i class="far fa-envelope me-1"></i> {{ $user->email }}</p>

                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge {{ $user->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2 rounded-pill">
                                {{ $user->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                {{ strtoupper($user->type->value ?? 'User') }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($user->type->value == 'representative')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-hotel me-2"></i>{{ __('Managed Hotels') }}</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" id="hotel-list-tab" role="tablist">
                            @foreach($user->hotels as $hotel)
                                <a class="list-group-item list-group-item-action @if($loop->first) active @endif p-3 border-0 border-bottom"
                                   id="hotel-tab-{{ $hotel->id }}"
                                   data-bs-toggle="pill"
                                   href="#hotel-content-{{ $hotel->id }}"
                                   role="tab">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-city me-2 opacity-50"></i>
                                        <span class="fw-bold small">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</span>
                                        <i class="fas fa-chevron-right ms-auto small opacity-50"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-8">

                @if($user->type->value == 'representative')
                    <div class="tab-content" id="hotel-tabs-main">
                        @foreach($user->hotels as $hotel)
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="hotel-content-{{ $hotel->id }}" role="tabpanel">

                                @php
                                    // جلب طلبات هذا الفندق وتجميعها بالتواريخ
                                    $ordersByDate = \App\Models\Order::where('hotel_id', $hotel->id)
                                        ->with(['user', 'orderable'])
                                        ->orderBy('date', 'asc')
                                        ->get()
                                        ->groupBy(function($item) {
                                            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                        })->sortKeys();
                                @endphp

                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-bottom-0 pb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0 fw-bold text-dark">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</h5>
                                            <span class="badge bg-primary-subtle text-primary border">{{ __('Daily Schedule') }}</span>
                                        </div>

                                        <div class="nav nav-pills d-flex flex-nowrap overflow-auto scrollbar-hidden pb-3 gap-3" role="tablist">
                                            @forelse($ordersByDate as $date => $orders)
                                                @php $carbonDate = \Carbon\Carbon::parse($date); @endphp
                                                <button class="nav-link date-item @if($loop->first) active @endif"
                                                        id="date-tab-{{ $hotel->id }}-{{ $date }}"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#date-content-{{ $hotel->id }}-{{ $date }}"
                                                        type="button" role="tab">
                                                    <span class="d-block small opacity-75">{{ $carbonDate->format('D') }}</span>
                                                    <span class="d-block fs-3 fw-bold my-1">{{ $carbonDate->format('d') }}</span>
                                                    <span class="d-block small fw-medium">{{ $carbonDate->format('M') }}</span>
                                                </button>
                                            @empty
                                                <div class="text-muted small p-2 fst-italic">{{ __('No dates found') }}</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="card-body bg-light-gray-soft rounded-bottom">
                                        <div class="tab-content">
                                            @foreach($ordersByDate as $date => $orders)
                                                <div class="tab-pane fade @if($loop->first) show active @endif" id="date-content-{{ $hotel->id }}-{{ $date }}" role="tabpanel">
                                                    <div class="row g-3">
                                                        @foreach($orders as $order)
                                                            <div class="col-md-6 col-xxl-6">
                                                                <div class="card border shadow-none trip-card h-100 mb-0">
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
                        @endforeach
                    </div>

                @elseif($user->type->value == 'supplier')
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-shuttle-van me-2 text-primary"></i>{{ __('My Assignments') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">{{ __('Order ID') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th class="pe-4 text-end">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->OrderStatus as $os)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ $os->order->order_number }}</td>
                                            <td><span class="badge bg-primary-subtle text-primary">{{ $os->status }}</span></td>
                                            <td class="small text-muted">{{ $os->order->date }}</td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ route('Admin.orders.show', $os->order->id) }}" class="btn btn-sm btn-light-primary btn-icon">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
    .scrollbar-hidden::-webkit-scrollbar { display: none; }
    .scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }

    /* تنسيق قائمة الفنادق */
    .list-group-item-action.active {
        background-color: #0d6efd10 !important;
        color: #0d6efd !important;
        border-left: 4px solid #0d6efd !important;
    }

    /* تنسيق التقويم */
    .date-item {
        min-width: 70px;
        height: 90px;
        background: #fff;
        border: 1px solid #eee !important;
        border-radius: 12px;
        color: #444;
        transition: 0.3s ease;
    }
    .date-item.active {
        background: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
        transform: translateY(-3px);
    }

    .trip-card { transition: 0.2s; border-radius: 12px; }
    .trip-card:hover { border-color: #0d6efd; transform: translateY(-3px); }
    .bg-light-gray-soft { background-color: #f8f9fa; }
    .f-10 { font-size: 10px; }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
</style>
@endsection

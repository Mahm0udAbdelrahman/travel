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

                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span class="badge {{ $user->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2 rounded-pill">
                                <i class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                {{ $user->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">
                                <i class="fas fa-id-badge me-1 text-primary"></i> {{ strtoupper($user->type->value ?? 'User') }}
                            </span>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="row text-start small mt-2">
                            <div class="col-6 mb-3">
                                <label class="text-muted d-block small text-uppercase fw-bold">{{ __('Phone') }}</label>
                                <span class="fw-bold">{{ $user->phone ?? '-' }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="text-muted d-block small text-uppercase fw-bold">{{ __('Created At') }}</label>
                                <span class="fw-bold text-nowrap">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($user->type->value == 'representative')
                            <div class="col-12">
                                <label class="text-muted d-block small text-uppercase fw-bold">{{ __('Assigned Hotels') }}</label>
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    @foreach($user->hotels as $hotel)
                                        <span class="badge bg-light text-dark border">{{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if (isset($user->files) && $user->files->isNotEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-paperclip me-2 text-primary"></i>{{ __('Attached Files') }}</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($user->files as $file)
                                <span class="badge bg-light text-primary border p-2">
                                    <i class="far fa-file-alt me-1"></i>
                                    {{ $file->name[app()->getLocale()] ?? $file->name['en'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-8">
                @php
                    // منطق جلب الداتا بناءً على النوع
                    if ($user->type->value == 'representative') {
                        $hotelIds = $user->hotels->pluck('id');
                        $orders = \App\Models\Order::whereIn('hotel_id', $hotelIds)->latest()->get();
                        $title = __('Orders for My Hotels');
                        $icon = 'fa-hotel';
                    } elseif ($user->type->value == 'supplier') {
                        $orders = $user->OrderStatus()->with('order')->latest()->get();
                        $title = __('Assigned Excursions');
                        $icon = 'fa-shuttle-van';
                    } else {
                        $orders = collect();
                        $title = __('Order History');
                        $icon = 'fa-shopping-bag';
                    }
                @endphp

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas {{ $icon }} me-2 text-primary"></i>{{ $title }}</h5>
                        <span class="badge bg-primary rounded-pill">{{ $orders->count() }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive text-center">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-start small fw-bold text-uppercase">{{ __('Order No.') }}</th>
                                        <th class="small fw-bold text-uppercase">{{ __('Status') }}</th>
                                        @if($user->type->value == 'representative')
                                            <th class="small fw-bold text-uppercase">{{ __('Hotel') }}</th>
                                        @endif
                                        <th class="small fw-bold text-uppercase">{{ __('Date') }}</th>
                                        <th class="pe-4 text-end small fw-bold text-uppercase">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $item)
                                        @php
                                            // إذا كان مورد، الداتا داخل OrderStatus، إذا كان مندوب الداتا مباشرة في Order
                                            $order = ($user->type->value == 'supplier') ? $item->order : $item;
                                            $statusLabel = ($user->type->value == 'supplier') ? $item->status : $order->status;
                                        @endphp
                                        <tr>
                                            <td class="ps-4 text-start fw-bold text-dark">#{{ $order->order_number ?? $order->id }}</td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                    {{ strtoupper($statusLabel) }}
                                                </span>
                                            </td>
                                            @if($user->type->value == 'representative')
                                                <td class="small fw-medium">{{ $order->hotel->name[app()->getLocale()] ?? 'N/A' }}</td>
                                            @endif
                                            <td class="text-muted small">
                                                {{ $order->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ route('Admin.orders.show', $order->id) }}" class="btn btn-sm btn-icon btn-light-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-muted small">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                                                {{ __('No orders found matching this profile.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm bg-light-subtle" style="background-color: #f8f9fa; border: 1px dashed #dee2e6 !important;">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex justify-content-between small text-muted">
                            <span><i class="far fa-calendar-plus me-1"></i> {{ __('Registered') }}: {{ $user->created_at->format('Y-m-d H:i') }}</span>
                            <span><i class="far fa-edit me-1"></i> {{ __('Update') }}: {{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .btn-icon { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.2s; }
    .btn-light-primary { background: #e7f1ff; color: #0d6efd; border: none; }
    .btn-light-primary:hover { background: #0d6efd; color: #fff; }
</style>
@endsection

@extends('dashboard.layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <div class="page-header mb-4">
            <div class="page-block d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Order Details</h4>
                    <p class="text-muted small mb-0">Reviewing information for Order <span class="text-primary fw-bold">#{{ $order->id }}</span></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('Admin.orders.index') }}" class="btn btn-light border shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <a href="{{ route('Admin.orders.edit', $order->id) }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-edit me-1"></i> Edit Order
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-file-invoice me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold d-block">Status</label>
                                <span class="badge rounded-pill bg-info-subtle text-info px-3 py-2 mt-1">
                                    <i class="fas fa-circle-notch fa-spin me-1 small"></i> {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold d-block">Payment Method</label>
                                <p class="mb-0 fw-bold text-dark"><i class="fas fa-credit-card me-1 text-muted"></i> {{ $order->payment_method ?? 'N/A' }}</p>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="text-muted small text-uppercase fw-bold d-block">Unit Price</label>
                                <p class="mb-0 fs-5 fw-bold">{{ number_format($order->price, 2) }}</p>
                            </div>
                            <div class="col-sm-4 mb-3 text-center border-start border-end">
                                <label class="text-muted small text-uppercase fw-bold d-block">Quantity</label>
                                <p class="mb-0 fs-5 fw-bold">x {{ $order->quantity }}</p>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="text-muted small text-uppercase fw-bold d-block">Grand Total</label>
                                <p class="mb-0 fs-5 fw-bold text-primary">{{ number_format($order->price * $order->quantity, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-box-open me-2"></i>Product / Item Details</h5>
                    </div>
                    <div class="card-body">
                        @if ($order->orderable)
                            @php $item = $order->orderable; @endphp
                            <div class="d-flex align-items-start align-items-md-center flex-column flex-md-row gap-4">
                                @if (isset($item->image))
                                    <img src="{{ asset($item->image) }}" class="rounded shadow-sm border p-1" width="140" alt="item">
                                @endif
                                <div class="flex-grow-1">
                                    <div class="badge bg-light text-secondary border mb-2">{{ class_basename($order->orderable_type) }} #{{ $item->id }}</div>
                                    <h4 class="fw-bold mb-2">{{ $item->name[app()->getLocale()] ?? 'Unnamed Item' }}</h4>
                                    @if(isset($item->description))
                                        <p class="text-muted mb-3">{{ Str::limit($item->description[app()->getLocale()], 150) }}</p>
                                    @endif
                                    <div class="d-flex gap-3 small text-muted">
                                        <span><i class="far fa-calendar-check me-1"></i>Added: {{ $item->created_at ? $item->created_at->format('M d, Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                                <p class="text-muted">No related item information found.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-history me-2"></i>Status Log</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Date</th>
                                        <th>Status</th>
                                        <th>Supplier Name</th>
                                        <th class="text-end pe-4">Supplier Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->statuses as $status)
                                    <tr>
                                        <td class="ps-4 small">{{ $status->created_at->format('Y-m-d H:i') }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary">{{ $status->status }}</span></td>
                                        <td>{{ $status->user->name ?? 'System' }}</td>
                                        <td class="text-end pe-4 font-monospace">{{ $status->user->phone ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted small">No history recorded</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 text-center border-bottom-0">
                        <h5 class="mb-0 text-dark fw-bold">Customer Profile</h5>
                    </div>
                    <div class="card-body text-center pt-0">
                        @if ($order->user)
                            <div class="avatar-xl bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <span class="fs-2 fw-bold text-primary">{{ substr($order->user->name, 0, 1) }}</span>
                            </div>
                            <h5 class="mb-1">{{ $order->user->name }}</h5>
                            <p class="text-muted small mb-4">Customer ID: #{{ $order->user->id }}</p>

                            <ul class="list-group list-group-flush text-start small border-top">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted"><i class="far fa-envelope me-2"></i>Email</span>
                                    <span class="fw-bold">{{ $order->user->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted"><i class="fas fa-phone me-2"></i>Phone</span>
                                    <span class="fw-bold">{{ $order->user->phone ?? '-' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted"><i class="far fa-calendar me-2"></i>Joined</span>
                                    <span class="fw-bold">{{ $order->user->created_at->format('M Y') }}</span>
                                </li>
                            </ul>
                        @else
                            <p class="text-muted mb-0 py-3">No user attached to this order.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ordered At:</span>
                            <span class="fw-bold text-dark text-end">{{ $order->created_at->format('M d, Y - H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Last Update:</span>
                            <span class="fw-bold text-dark text-end">{{ $order->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    /* تحسينات التصميم */
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .avatar-xl { background-color: #f0f4f9; color: #0d6efd; border: 2px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .list-group-item { background: transparent; border-bottom: 1px dashed #eee; }
    .card { overflow: hidden; }
</style>
@endsection

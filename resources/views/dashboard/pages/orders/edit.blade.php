@extends('dashboard.layouts.app')
@section('title', __('Edit Order') . ' #' . $order->order_number)

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="page-header-title">
                            <h4 class="mb-0 text-primary"><i class="fas fa-edit me-2"></i>{{ __('Edit Order Details') }}</h4>
                            <small class="text-muted">Order Reference: <strong>#{{ $order->order_number }}</strong></small>
                        </div>
                        <a href="{{ route('Admin.reports') }}" class="btn btn-light-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Reports
                        </a>
                    </div>
                </div>
            </div>

            @php
                $types = [$real_estate, $event, $excursion, $offer, $additional_service];
            @endphp

            <form method="POST" action="{{ route('Admin.orders.update', $order->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light-primary py-3">
                                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Customer & Location</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted small text-uppercase">Customer Info</label>
                                    <div class="d-flex align-items-center p-2 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                {{ substr($order->user?->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">{{ $order->user?->name }}</h6>
                                            <p class="mb-0 small text-muted"><i
                                                    class="fas fa-phone-alt me-1"></i>{{ $order->user?->phone ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted small text-uppercase">Hotel</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i
                                                class="fas fa-hotel text-primary"></i></span>
                                        <input type="text" class="form-control border-start-0 bg-light"
                                            value="{{ $order->hotel?->name['en'] ?? '-' }}" readonly>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label fw-bold text-muted small text-uppercase">Room Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i
                                                class="fas fa-door-open text-primary"></i></span>
                                        <input type="text" name="room_number"
                                            class="form-control border-start-0 shadow-none"
                                            value="{{ $order->room_number }}" placeholder="Enter Room No.">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Service Selection & Pricing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    {{-- Service Type --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Service Category</label>
                                        <select id="typeSelect" name="orderable_type"
                                            class="form-select border-light-subtle">
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}"
                                                    {{ $order->orderable_type == $type ? 'selected' : '' }}>
                                                    {{ class_basename($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Specific Item --}}
                                    {{--  <div class="col-md-6">
                                        <label class="form-label fw-bold small">Specific Item</label>
                                        <select id="itemSelect" name="orderable_id"
                                            class="form-select border-light-subtle select2">
                                            <option value="{{ $order->orderable_id }}">#{{ $order->orderable_id }}
                                            </option>
                                        </select>
                                    </div>  --}}
                                    {{-- Booking Date --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small text-primary">Execution Date</label>
                                        <input type="date" name="date"
                                            value="{{ $order->date ? date('Y-m-d', strtotime($order->date)) : '' }}"
                                            class="form-control shadow-none border-primary-subtle">
                                    </div>

                                    {{-- Booking Time --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small text-primary">Execution Time</label>
                                        <input type="time" name="time"
                                            value="{{ $order->time ? date('H:i', strtotime($order->time)) : '' }}"
                                            class="form-control shadow-none border-primary-subtle">
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Order Status</label>
                                        <select name="status" class="form-select border-warning-subtle">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending
                                            </option>
                                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>✅
                                                Confirmed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌
                                                Cancelled</option>
                                        </select>
                                    </div>

                                    {{-- Quantity --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Quantity</label>
                                        <input type="number" name="quantity" value="{{ $order->quantity }}"
                                            class="form-control shadow-none">
                                    </div>

                                    {{-- Price --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Total Price ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success-subtle text-success">$</span>
                                            <input type="number" step="0.01" name="price"
                                                value="{{ $order->price }}" class="form-control shadow-none fw-bold">
                                        </div>
                                    </div>

                                    {{-- Payment Status --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold small">Payment Status</label>
                                        <select name="payment_status" class="form-select border-info-subtle">
                                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                                Unpaid</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                                Fully Paid</option>
                                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>
                                                Failed</option>
                                        </select>
                                    </div>

                                    {{-- Notes --}}
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Administrative Notes</label>
                                        <textarea name="notes" class="form-control shadow-none" rows="4" placeholder="Any special instructions...">{{ $order->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light py-3 text-end">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Update Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <style>
        .bg-light-primary {
            background-color: #f0f4ff;
            color: #0046ff;
            border-bottom: 1px solid #e1e7f5;
        }

        .form-label {
            margin-bottom: 0.4rem;
            color: #4a5568;
        }

        .card {
            border-radius: 12px;
            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0046ff;
            box-shadow: 0 0 0 0.2rem rgba(0, 70, 255, 0.1);
        }

        .avatar {
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('typeSelect');
            const itemSelect = document.getElementById('itemSelect');

            function loadItems(type, selectedId = null) {
                // إظهار حالة تحميل بسيطة
                itemSelect.innerHTML = '<option>Loading...</option>';

                fetch("/admin/orders/load-items?type=" + encodeURIComponent(type))
                    .then(res => res.json())
                    .then(data => {
                        itemSelect.innerHTML = '';
                        data.forEach(row => {
                            let opt = document.createElement('option');
                            opt.value = row.id;
                            opt.text = row.name ? (row.name.en || row.name) : (row.title || ('#' + row
                                .id));

                            if (selectedId && selectedId == row.id) {
                                opt.selected = true;
                            }
                            itemSelect.appendChild(opt);
                        });
                    });
            }

            loadItems(typeSelect.value, "{{ $order->orderable_id }}");

            typeSelect.addEventListener('change', function() {
                loadItems(this.value);
            });
        });
    </script>
@endpush

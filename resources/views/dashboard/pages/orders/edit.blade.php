@extends('dashboard.layouts.app')
@section('title', __('Edit Order'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0">{{ __('Edit Order') }}</h5>
                </div>
            </div>
        </div>

        @php
            $types = [
                $real_estate,
                $event,
                $excursion,
                $offer,
                $additional_service
            ];
        @endphp

        <div class="row">
            <div class="col-12">
                <form method="POST"
                      action="{{ route('Admin.orders.update',$order->id) }}"
                      class="card shadow rounded p-3 bg-white">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select id="typeSelect" name="orderable_type" class="form-select">
                                @foreach($types as $type)
                                    <option value="{{ $type }}"
                                        {{ $order->orderable_type == $type ? 'selected' : '' }}>
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Item --}}
                        <div class="col-md-6">
                            <label class="form-label">Item</label>
                            <select id="itemSelect" name="orderable_id" class="form-select">
                                <option value="{{ $order->orderable_id }}">
                                    #{{ $order->orderable_id }}
                                </option>
                            </select>
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number"
                                   name="quantity"
                                   value="{{ $order->quantity }}"
                                   class="form-control">
                        </div>

                        {{-- Price --}}
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   value="{{ $order->price }}"
                                   class="form-control">
                        </div>

                        {{-- Date --}}
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date"
                                   name="date"
                                   value="{{ $order->date }}"
                                   class="form-control">
                        </div>

                        {{-- Time --}}
                        <div class="col-md-4">
                            <label class="form-label">Time</label>
                            <input type="time"
                                   name="time"
                                   value="{{ $order->time }}"
                                   class="form-control">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Confirmed</option>
                                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                            </select>
                        </div>

                        {{-- Payment Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="pending" {{ $order->payment_status=='pending'?'selected':'' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status=='paid'?'selected':'' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status=='failed'?'selected':'' }}>Failed</option>
                            </select>
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes"
                                      class="form-control"
                                      rows="3">{{ $order->notes }}</textarea>
                        </div>

                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-4">
                            Update Order
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('typeSelect');
    const itemSelect = document.getElementById('itemSelect');

    function loadItems(type, selectedId = null) {
        fetch("/admin/orders/load-items?type=" + encodeURIComponent(type))
            .then(res => res.json())
            .then(data => {
                itemSelect.innerHTML = '';

                data.forEach(row => {
                    let opt = document.createElement('option');
                    opt.value = row.id;
                    opt.text = row.name ?? row.title ?? ('#'+row.id);

                    if (selectedId && selectedId == row.id) {
                        opt.selected = true;
                    }

                    itemSelect.appendChild(opt);
                });
            });
    }

    // تحميل أولي
    loadItems(typeSelect.value, "{{ $order->orderable_id }}");

    typeSelect.addEventListener('change', function () {
        loadItems(this.value);
    });

});
</script>


@endpush

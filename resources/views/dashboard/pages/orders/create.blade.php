@extends('dashboard.layouts.app')
@section('title', __('Add Order'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0">{{ __('Add Order') }}</h5>
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
                      action="{{ route('Admin.orders.store') }}"
                      class="card shadow rounded p-3 bg-white">
                    @csrf

                    <div class="row g-3">

                        {{-- Orderable Type --}}
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select id="typeSelect" name="orderable_type" class="form-select">
                                <option value="">Choose type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Orderable Item --}}
                        <div class="col-md-6">
                            <label class="form-label">Item</label>
                            <select id="itemSelect" name="orderable_id" class="form-select">
                                <option value="">Choose item</option>
                            </select>
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity"
                                   value="1"
                                   class="form-control">
                        </div>

                        {{-- Price --}}
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01"
                                   name="price"
                                   class="form-control">
                        </div>

                        {{-- Date --}}
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" name="date"
                                   class="form-control">
                        </div>

                        {{-- Time --}}
                        <div class="col-md-4">
                            <label class="form-label">Time</label>
                            <input type="time" name="time"
                                   class="form-control">
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes"
                                      class="form-control"
                                      rows="3"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tour Leader</label>
                            <select name="is_tour_leader" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-4">
                            Save Order
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

    typeSelect.addEventListener('change', function () {

        itemSelect.innerHTML = '<option>Loading...</option>';

        fetch("/admin/orders/load-items?type=" + encodeURIComponent(this.value))
            .then(res => res.json())
            .then(data => {
                itemSelect.innerHTML = '<option value="">Choose item</option>';

                data.forEach(row => {
                    let opt = document.createElement('option');
                    opt.value = row.id;
                    opt.text = row.name ?? row.title ?? ('#'+row.id);
                    itemSelect.appendChild(opt);
                });
            });

    });

});
</script>

@endpush

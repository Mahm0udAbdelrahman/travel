@extends('dashboard.layouts.app')
@section('title', __('Add Offer'))

@push('styles')
    <style>
        .excursion-card-wrapper { transition: all .2s ease; border: 1px solid #eee; }
        .excursion-card-wrapper:hover { border-color: #0d6efd; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 0, 0, .08); }
        .excursion-checkbox { transform: scale(1.2); cursor: pointer; }
        .cursor-pointer { cursor: pointer; }
        .bg-light-alt { background-color: #f8f9fa; }
        .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
        .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    </style>
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0">{{ __('Add Offer') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.offers.index') }}">{{ __('Offers') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Add Offer') }}</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('Admin.offers.store') }}" enctype="multipart/form-data">
                @csrf

                @php
                    $langs = [
                        'ar' => 'Arabic', 'en' => 'English', 'es' => 'Spanish',
                        'it' => 'Italian', 'de' => 'German', 'ja' => 'Japanese',
                        'zh' => 'Chinese', 'ru' => 'Russian', 'fr' => 'French',
                    ];
                @endphp

                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">{{ __('Offer Translations') }}</h6>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            @foreach ($langs as $key => $lang)
                                <li class="nav-item">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#lang-{{ $key }}" type="button">{{ $lang }}</button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach ($langs as $key => $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Name ({{ $lang }})</label>
                                            <input type="text" name="name[{{ $key }}]" value="{{ old("name.$key") }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Description ({{ $lang }})</label>
                                            <input type="text" name="description[{{ $key }}]" value="{{ old("description.$key") }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ __('Offer Information') }}</h6>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <input type="text" name="price" value="{{ old('price') }}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ __('Settings') }}</h6>
                            </div>
                            <div class="card-body">
                                <label class="form-label">{{ __('Image') }}</label>
                                <input type="file" name="image" class="form-control mb-3">

                                <label class="form-label">{{ __('Status') }}</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center g-3">
                            <div class="col-md-4">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-map-marked-alt me-2"></i> {{ __('Select Excursions') }}
                                </h6>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                    <select id="categoryFilter" class="form-select form-select-sm w-auto">
                                        <option value="">{{ __('All Categories') }}</option>
                                        @foreach ($categoryExcursions as $category)
                                            <option value="{{ $category->id }}">{{ $category->name['en'] ?? '' }}</option>
                                        @endforeach
                                    </select>

                                    <div class="input-group input-group-sm w-auto">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                                        <input type="text" id="excursionSearch" class="form-control border-start-0" placeholder="{{ __('Search...') }}">
                                    </div>

                                    <div class="btn-group btn-group-sm">
                                        <button type="button" id="selectAll" class="btn btn-outline-primary">{{ __('Select All') }}</button>
                                        <button type="button" id="clearAll" class="btn btn-outline-danger">{{ __('Clear All') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-light-alt" style="max-height: 500px; overflow-y:auto;">
                        <div class="row g-3">
                            @foreach ($excursions as $excursion)
                                <div class="col-xl-4 col-md-6 excursion-item" data-category="{{ $excursion->category_excursion_id }}">
                                    <div class="card h-100 border-0 shadow-sm excursion-card-wrapper">
                                        <label class="card-body p-3 cursor-pointer mb-0" for="excursion-{{ $excursion->id }}">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark">{{ $excursion->name['en'] ?? '' }}</h6>
                                                    <small class="text-muted"><i class="fas fa-location-arrow me-1"></i>{{ $excursion->city->name[app()->getLocale()] ?? '' }}</small>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input excursion-checkbox custom-check"
                                                           type="checkbox" value="{{ $excursion->id }}"
                                                           name="excursion_ids[]" id="excursion-{{ $excursion->id }}"
                                                           data-price="{{ $excursion->price }}">
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-soft-primary text-primary px-2">
                                                    <i class="far fa-clock me-1"></i>{{ $excursion->hours ?? '-' }} {{ __('Hrs') }}
                                                </span>
                                                <span class="badge bg-soft-success text-success px-2 fw-bold">
                                                    ${{ number_format($excursion->price, 2) }}
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer bg-white py-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">{{ __('Calculation Summary') }}</span>
                                <span class="fw-bold h5 mb-0 text-dark">
                                    <i class="fas fa-wallet me-1 text-primary"></i> {{ __('Total Price') }}
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="h3 fw-bold text-primary mb-0">$<span id="totalPrice">0.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light d-flex justify-content-between">
                        <h6 class="mb-0">{{ __('Offer Times') }}</h6>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addTime()">+ {{ __('Add Time') }}</button>
                    </div>
                    <div class="card-body" id="times-wrapper">
                        </div>
                </div>

                <div class="text-end mb-5">
                    <button class="btn btn-primary px-5 shadow">
                        <i class="ti ti-device-floppy me-1"></i> {{ __('Save Offer') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.excursion-checkbox');
            const excursionItems = document.querySelectorAll('.excursion-item');
            const totalPriceEl = document.getElementById('totalPrice');

            // 1. Calculate Total Price
            function calculate() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) total += parseFloat(cb.dataset.price) || 0;
                });
                totalPriceEl.innerText = total.toFixed(2);
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculate);
            });

            // 2. Category Filter
            document.getElementById('categoryFilter').addEventListener('change', function() {
                const val = this.value;
                excursionItems.forEach(item => {
                    item.style.display = (!val || item.dataset.category === val) ? 'block' : 'none';
                });
            });

            // 3. Search Filter
            document.getElementById('excursionSearch').addEventListener('keyup', function() {
                const key = this.value.toLowerCase();
                excursionItems.forEach(item => {
                    item.style.display = item.innerText.toLowerCase().includes(key) ? 'block' : 'none';
                });
            });

            // 4. Select All (Visible only)
            document.getElementById('selectAll').addEventListener('click', () => {
                excursionItems.forEach(item => {
                    if (item.style.display !== 'none') {
                        item.querySelector('.excursion-checkbox').checked = true;
                    }
                });
                calculate();
            });

            // 5. Clear All
            document.getElementById('clearAll').addEventListener('click', () => {
                checkboxes.forEach(cb => cb.checked = false);
                calculate();
            });

            calculate();
        });

        // 6. Dynamic Times Logic
        let timeIndex = 0;
        function addTime() {
            const wrapper = document.getElementById('times-wrapper');
            let html = `
                <div class="row g-2 mb-2 align-items-end time-block shadow-sm p-2 rounded border-start border-primary border-3">
                    <div class="col-md-5">
                        <label class="form-label small mb-1">{{ __('From Time') }}</label>
                        <input type="time" name="times[${timeIndex}][from_time]" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small mb-1">{{ __('To Time') }}</label>
                        <input type="time" name="times[${timeIndex}][to_time]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.time-block').remove()">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
            timeIndex++;
        }
    </script>
@endpush

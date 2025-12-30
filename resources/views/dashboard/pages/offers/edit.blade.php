@extends('dashboard.layouts.app')
@section('title', __('Edit Offer'))
@push('styles')
<style>
    .excursion-card {
        transition: all .2s ease;
        cursor: pointer;
    }
    .excursion-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
    }
    .excursion-checkbox {
        transform: scale(1.2);
    }
</style>
@endpush

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0">{{ __('Edit Offer') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.offers.index') }}">{{ __('Offers') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Offer') }}</li>
                </ul>
            </div>
        </div>

        <form method="POST" action="{{ route('Admin.offers.update', $offer->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Languages Tabs --}}
            @php
                $langs = [
                    'ar' => 'Arabic',
                    'en' => 'English',
                    'es' => 'Spanish',
                    'it' => 'Italian',
                    'de' => 'German',
                    'ja' => 'Japanese',
                    'zh' => 'Chinese',
                    'ru' => 'Russian',
                    'fr' => 'French',
                ];
            @endphp

            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">{{ __('Event Translations') }}</h6>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        @foreach ($langs as $key => $lang)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#lang-{{ $key }}" type="button">
                                    {{ $lang }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($langs as $key => $lang)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name ({{ $lang }})</label>
                                        <input type="text" name="name[{{ $key }}]"
                                             value="{{ old("name.$key", data_get($offer->name, $key)) }}"
                                            class="form-control">
                                        @error("name.$key")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description ({{ $lang }})</label>
                                        <input type="text" name="description[{{ $key }}]"
                                             value="{{ old("description.$key", data_get($offer->description, $key)) }}"
                                            class="form-control">
                                        @error("description.$key")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Main Info --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{ __('Offer Information') }}</h6>
                        </div>
                        <div class="card-body row g-3">

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Price') }}</label>
                                <input type="text" name="price" value="{{ old('price', $offer->price) }}" class="form-control">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" name="start_date" value="{{ old('start_date', $offer->start_date) }}"
                                    class="form-control">
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('End Date') }}</label>
                                <input type="date" name="end_date" value="{{ old('end_date', $offer->end_date) }}"
                                    class="form-control">
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Settings --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{ __('Settings') }}</h6>
                        </div>
                        <div class="card-body">

                            <label class="form-label">{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control mb-3">
                            @if($offer->image)
                                <img src="{{ asset($offer->image) }}" alt="Offer Image" class="img-fluid mb-3" style="max-height: 150px;">
                            @endif
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active', $offer->is_active) == '1' ? 'selected' : '' }}>
                                    {{ __('Active') }}
                                </option>
                                <option value="0" {{ old('is_active', $offer->is_active) == '0' ? 'selected' : '' }}>
                                    {{ __('UnActive') }}
                                </option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= Excursions ================= --}}
            <div class="card shadow-sm border-0 mb-4">

                {{-- Header --}}
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="ti ti-map-pin"></i> Select Excursions
                    </h6>

                    <div class="d-flex gap-2">
                        <select id="categoryFilter" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach ($categoryExcursions as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name['en'] ?? '' }}
                                </option>
                            @endforeach
                        </select>

                        <input type="text"
                            id="excursionSearch"
                            class="form-control form-control-sm"
                            placeholder="Search...">

                        <button type="button" id="selectAll"
                            class="btn btn-sm btn-outline-primary">
                            Select All
                        </button>

                        <button type="button" id="clearAll"
                            class="btn btn-sm btn-outline-secondary">
                            Clear
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body" style="max-height: 450px; overflow:auto">
                    <div class="row g-3">

                        @foreach ($excursions as $excursion)
                            <div class="col-md-6 excursion-item"
                                data-category="{{ $excursion->category_excursion_id }}">

                                <label class="card h-100 border p-3 excursion-card">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                {{ $excursion->name['en'] ?? '' }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $excursion->city->name[app()->getLocale()] ?? '' }}
                                            </small>
                                        </div>

                                        <input class="form-check-input excursion-checkbox"
                                            type="checkbox"
                                            value="{{ $excursion->id }}"
                                            data-price="{{ $excursion->price }}"
                                            name="excursion_ids[]"
                                            {{ in_array($excursion->id, old('excursion_ids', $offer->excursions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    </div>

                                    <div class="mt-3 d-flex justify-content-between">
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $excursion->hours ?? '-' }} Hours
                                        </span>

                                        <span class="fw-bold text-success">
                                            ${{ $excursion->price }}
                                        </span>
                                    </div>
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">
                        <i class="ti ti-calculator me-1"></i>
                        Total Excursions Price
                    </span>

                    <span class="fs-5 fw-bold text-primary">
                        $<span id="totalPrice">0.00</span>
                    </span>
                </div>
            </div>

            {{-- Submit --}}
            <div class="text-end mb-5">
                <button class="btn btn-primary px-5">
                    <i class="ti ti-device-floppy"></i> {{ __('Update Offer') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.excursion-checkbox');
    const excursionItems = document.querySelectorAll('.excursion-item');

    const totalPriceEl = document.getElementById('totalPrice');

    function calculate() {
        let total = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) total += parseFloat(cb.dataset.price);
        });

        totalPriceEl.innerText = total.toFixed(2);
    }

    checkboxes.forEach(cb => cb.addEventListener('change', calculate));

    // Category Filter
    document.getElementById('categoryFilter').addEventListener('change', function () {
        const val = this.value;
        excursionItems.forEach(item => {
            item.style.display = (!val || item.dataset.category === val) ? 'block' : 'none';
        });
    });

    // Search
    document.getElementById('excursionSearch').addEventListener('keyup', function () {
        const key = this.value.toLowerCase();
        excursionItems.forEach(item => {
            item.style.display = item.innerText.toLowerCase().includes(key)
                ? 'block' : 'none';
        });
    });

    // Select / Clear
    document.getElementById('selectAll').onclick = () => {
        excursionItems.forEach(item => {
            if (item.style.display !== 'none') {
                item.querySelector('.excursion-checkbox').checked = true;
            }
        });
        calculate();
    };

    document.getElementById('clearAll').onclick = () => {
        checkboxes.forEach(cb => cb.checked = false);
        calculate();
    };

    calculate(); // حساب أولي لما الصفحة تحمل
});
</script>
@endpush

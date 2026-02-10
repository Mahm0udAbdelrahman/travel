@extends('dashboard.layouts.app')
@section('title', __('Edit Offer'))
@push('styles')
    <style>
        /* نفس ستايل create */
        .excursion-card {
            transition: all .2s ease;
            cursor: pointer;
        }
        .excursion-card:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }
        .excursion-checkbox {
            transform: scale(1.2);
        }
        /* ... إضافة باقي التنسيقات كما هي ... */
    </style>
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

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

                    // بيانات الرحلات المرتبطة بالعرض للتسهيل
                    $selectedExcursions = $offer->excursions()->withPivot('excursion_day_id', 'excursion_time_id')->get();
                @endphp

                {{-- لغات الترجمة --}}
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">{{ __('Event Translations') }}</h6>
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

                {{-- بيانات العرض الأساسية --}}
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
                                    <input type="date" name="start_date" value="{{ old('start_date', $offer->start_date) }}" class="form-control">
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" value="{{ old('end_date', $offer->end_date) }}" class="form-control">
                                    @error('end_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                @if($offer->image)
                                    <img src="{{ asset('storage/excursion/'.$offer->image) }}" alt="Offer Image" class="img-fluid mb-3" />
                                @endif
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <label class="form-label">{{ __('Status') }}</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', $offer->is_active) == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ old('is_active', $offer->is_active) == '0' ? 'selected' : '' }}>{{ __('UnActive') }}</option>
                                </select>
                                @error('is_active')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>

                {{-- قسم الرحلات --}}
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
                                        <button type="button" id="clearAll" class="btn btn-outline-danger">{{ __('Clear') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-light-alt" style="max-height: 550px; overflow-y:auto; overflow-x:hidden;">
                        <div class="row g-3">
                            @foreach ($excursions as $excursion)
                                @php
                                    $pivotData = $selectedExcursions->firstWhere('id', $excursion->id)?->pivot;
                                    $selectedDayId = $pivotData ? $pivotData->excursion_day_id : null;
                                    $selectedTimeId = $pivotData ? $pivotData->excursion_time_id : null;
                                @endphp
                                <div class="col-xl-4 col-md-6 excursion-item" data-category="{{ $excursion->category_excursion_id }}">
                                    <div class="card h-100 border-0 shadow-sm excursion-card-wrapper transition-all {{ $pivotData ? 'selected' : '' }}">
                                        <label class="card-body p-0 cursor-pointer" for="excursion-{{ $excursion->id }}">
                                            <div class="p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div style="max-width: 80%;">
                                                        <h6 class="fw-bold mb-0 text-dark">{{ $excursion->name['en'] ?? '' }}</h6>
                                                        <small class="text-muted"><i class="fas fa-location-arrow f-10"></i> {{ $excursion->city->name[app()->getLocale()] ?? '' }}</small>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input excursion-checkbox custom-check" type="checkbox" value="{{ $excursion->id }}" name="excursion_ids[]" id="excursion-{{ $excursion->id }}"
                                                            {{ $pivotData ? 'checked' : '' }}
                                                            data-price="{{ $excursion->price }}">
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2 mt-2">
                                                    <span class="badge bg-soft-primary text-primary px-2">
                                                        <i class="far fa-clock me-1"></i>{{ $excursion->hours ?? '-' }} {{ __('Hrs') }}
                                                    </span>
                                                    <span class="badge bg-soft-success text-success px-2 font-weight-bold">
                                                        ${{ number_format($excursion->price, 2) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <hr class="my-0 opacity-10">

                                            <div class="p-3 bg-white selection-area">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label class="x-small fw-bold text-muted mb-1">{{ __('Day') }}</label>
                                                        <select name="days[{{ $excursion->id }}]" id="day-{{ $excursion->id }}" class="form-select form-select-sm excursion-day-select border-dashed" data-excursion-id="{{ $excursion->id }}" {{ $pivotData ? '' : 'disabled' }}>
                                                            <option value="">-- {{ __('Day') }} --</option>
                                                            @foreach ($excursion->days as $day)
                                                                <option value="{{ $day->id }}" {{ $selectedDayId == $day->id ? 'selected' : '' }}>
                                                                    {{ $day->day }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="x-small fw-bold text-muted mb-1">{{ __('Time') }}</label>
                                                        <select name="times[{{ $excursion->id }}]" id="time-{{ $excursion->id }}" class="form-select form-select-sm excursion-time-select border-dashed" {{ $selectedDayId ? '' : 'disabled' }}>
                                                            <option value="">-- {{ __('Time') }} --</option>
                                                            @if($selectedDayId)
                                                                @php
                                                                    $selectedDay = $excursion->days->firstWhere('id', $selectedDayId);
                                                                @endphp
                                                                @if($selectedDay)
                                                                    @foreach ($selectedDay->times as $time)
                                                                        <option value="{{ $time->id }}" {{ $selectedTimeId == $time->id ? 'selected' : '' }}>
                                                                            {{ $time->from_time }} - {{ $time->to_time }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
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
                                <span class="fw-bold h5 mb-0 text-dark"><i class="fas fa-wallet me-1 text-primary"></i> {{ __('Total Price') }}</span>
                            </div>
                            <div class="text-end">
                                <span class="h3 fw-bold text-primary mb-0">$<span id="totalPrice">0.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button class="btn btn-primary px-5"><i class="ti ti-device-floppy"></i> {{ __('Save Offer') }}</button>
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

            const excursions = @json($excursions->load('days.times'));

            const selectedTimes = @json($selectedExcursions->mapWithKeys(function($item) {
                return [$item->id => $item->pivot->excursion_time_id];
            }));

            function calculate() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) total += parseFloat(cb.dataset.price);
                });
                totalPriceEl.innerText = total.toFixed(2);
            }

            checkboxes.forEach(cb => {
                const excursionId = cb.value;
                const daySelect = document.getElementById(`day-${excursionId}`);
                const timeSelect = document.getElementById(`time-${excursionId}`);

                if(cb.checked) {
                    daySelect.disabled = false;

                    if(daySelect.value) {
                        populateTimes(excursionId, daySelect.value, timeSelect);
                        timeSelect.disabled = false;
                        if(selectedTimes[excursionId]) {
                            timeSelect.value = selectedTimes[excursionId];
                        }
                    }
                } else {
                    daySelect.disabled = true;
                    daySelect.value = '';
                    timeSelect.disabled = true;
                    timeSelect.innerHTML = '<option value="">Select Time</option>';
                }

                cb.addEventListener('change', function() {
                    if(this.checked) {
                        daySelect.disabled = false;
                    } else {
                        daySelect.value = '';
                        daySelect.disabled = true;
                        timeSelect.innerHTML = '<option value="">Select Time</option>';
                        timeSelect.disabled = true;
                    }
                    calculate();
                });
            });

            document.querySelectorAll('.excursion-day-select').forEach(daySelect => {
                daySelect.addEventListener('change', function() {
                    const excursionId = this.dataset.excursionId;
                    const selectedDayId = this.value;
                    const timeSelect = document.getElementById(`time-${excursionId}`);

                    timeSelect.innerHTML = '<option value="">Select Time</option>';
                    timeSelect.disabled = true;

                    if (!selectedDayId) return;

                    populateTimes(excursionId, selectedDayId, timeSelect);
                    timeSelect.disabled = false;
                });
            });

            function populateTimes(excursionId, dayId, timeSelect) {
                const excursion = excursions.find(e => e.id == excursionId);
                if(!excursion) return;

                const day = excursion.days.find(d => d.id == dayId);
                if(!day || !day.times) return;

                day.times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.id;
                    option.textContent = `${time.from_time} - ${time.to_time}`;
                    timeSelect.appendChild(option);
                });

                if(selectedTimes[excursionId]) {
                    timeSelect.value = selectedTimes[excursionId];
                }
            }

            document.getElementById('categoryFilter').addEventListener('change', function() {
                const val = this.value;
                excursionItems.forEach(item => {
                    item.style.display = (!val || item.dataset.category === val) ? 'block' : 'none';
                });
            });

            document.getElementById('excursionSearch').addEventListener('keyup', function() {
                const key = this.value.toLowerCase();
                excursionItems.forEach(item => {
                    item.style.display = item.innerText.toLowerCase().includes(key) ? 'block' : 'none';
                });
            });

            document.getElementById('selectAll').onclick = () => {
                excursionItems.forEach(item => {
                    if (item.style.display !== 'none') {
                        const cb = item.querySelector('.excursion-checkbox');
                        cb.checked = true;
                        document.getElementById(`day-${cb.value}`).disabled = false;
                    }
                });
                calculate();
            };

            document.getElementById('clearAll').onclick = () => {
                excursionItems.forEach(item => {
                    const cb = item.querySelector('.excursion-checkbox');
                    cb.checked = false;
                    const daySelect = document.getElementById(`day-${cb.value}`);
                    const timeSelect = document.getElementById(`time-${cb.value}`);
                    daySelect.value = '';
                    daySelect.disabled = true;
                    timeSelect.innerHTML = '<option value="">Select Time</option>';
                    timeSelect.disabled = true;
                });
                calculate();
            };

            calculate();
        });
    </script>
@endpush

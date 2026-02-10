@extends('dashboard.layouts.app')
@section('title', __('Edit Offer'))

@push('styles')
    <style>
        .excursion-card-wrapper {
            transition: all .2s ease;
            cursor: pointer;
            border: 1px solid #eee;
            border-radius: 12px;
        }

        .excursion-card-wrapper:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .excursion-checkbox {
            transform: scale(1.2);
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            {{-- header --}}
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
                    $selectedExcursions = $offer
                        ->excursions()
                        ->withPivot('excursion_day_id', 'excursion_time_id')
                        ->get();
                @endphp

                {{-- translations --}}
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">{{ __('Event Translations') }}</h6>
                    </div>

                    <div class="card-body">

                        <ul class="nav nav-tabs mb-4">
                            @foreach ($langs as $key => $lang)
                                <li class="nav-item">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#lang-{{ $key }}">
                                        {{ $lang }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach ($langs as $key => $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $key }}">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label>Name ({{ $lang }})</label>
                                            <input name="name[{{ $key }}]" class="form-control"
                                                value="{{ old("name.$key", data_get($offer->name, $key)) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Description ({{ $lang }})</label>
                                            <input name="description[{{ $key }}]" class="form-control"
                                                value="{{ old("description.$key", data_get($offer->description, $key)) }}">
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- offer info --}}
                <div class="row">

                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6>{{ __('Offer Information') }}</h6>
                            </div>
                            <div class="card-body row g-3">

                                <div class="col-md-6">
                                    <label>{{ __('Price') }}</label>
                                    <input name="price" value="{{ old('price', $offer->price) }}" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date"
                                        value="{{ old('start_date', $offer->start_date) }}" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" value="{{ old('end_date', $offer->end_date) }}"
                                        class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6>{{ __('Settings') }}</h6>
                            </div>
                            <div class="card-body">

                                <label>{{ __('Image') }}</label>
                                <input type="file" name="image" class="form-control mb-3">

                                @if ($offer->image)
                                    <img src="{{ asset('storage/excursion/' . $offer->image) }}" class="img-fluid mb-3">
                                @endif

                                <label>{{ __('Status') }}</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ $offer->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$offer->is_active ? 'selected' : '' }}>UnActive</option>
                                </select>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- excursions --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="text-primary"><i class="fas fa-map-marked-alt"></i> {{ __('Select Excursions') }}</h6>
                    </div>

                    <div class="card-body" style="max-height:550px;overflow:auto">
                        <div class="row g-3">

                            @foreach ($excursions as $excursion)
                                @php
                                    $pivot = $selectedExcursions->firstWhere('id', $excursion->id)?->pivot;
                                    $selectedDay = $pivot?->excursion_day_id;
                                    $selectedTime = $pivot?->excursion_time_id;
                                @endphp

                                <div class="col-md-4 excursion-item"
                                    data-category="{{ $excursion->category_excursion_id }}">
                                    <div class="excursion-card-wrapper p-3 {{ $pivot ? 'selected' : '' }}">

                                        <div class="d-flex justify-content-between">
                                            <h6>{{ $excursion->name['en'] ?? '' }}</h6>
                                            <input type="checkbox" class="excursion-checkbox" name="excursion_ids[]"
                                                value="{{ $excursion->id }}" data-price="{{ $excursion->price }}"
                                                {{ $pivot ? 'checked' : '' }}>
                                        </div>

                                        <div class="mt-2">
                                            <span class="badge bg-primary">{{ $excursion->hours }} Hrs</span>
                                            <span class="badge bg-success">${{ number_format($excursion->price, 2) }}</span>
                                        </div>

                                        <select name="days[{{ $excursion->id }}]" id="day-{{ $excursion->id }}"
                                            class="form-select form-select-sm mt-2 excursion-day-select"
                                            data-excursion-id="{{ $excursion->id }}" {{ $pivot ? '' : 'disabled' }}>
                                            <option value="">Day</option>
                                            @foreach ($excursion->days as $day)
                                                <option value="{{ $day->id }}"
                                                    {{ $selectedDay == $day->id ? 'selected' : '' }}>
                                                    {{ $day->day }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select name="times[{{ $excursion->id }}]" id="time-{{ $excursion->id }}"
                                            class="form-select form-select-sm mt-2" {{ $selectedDay ? '' : 'disabled' }}>
                                            <option value="">Time</option>
                                            @if ($selectedDay)
                                                @foreach ($excursion->days->firstWhere('id', $selectedDay)?->times ?? [] as $time)
                                                    <option value="{{ $time->id }}"
                                                        {{ $selectedTime == $time->id ? 'selected' : '' }}>
                                                        {{ $time->from_time }} - {{ $time->to_time }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <h4>$<span id="totalPrice">0.00</span></h4>
                    </div>

                </div>

                <div class="text-end mb-5">
                    <button class="btn btn-primary px-5">{{ __('Save Offer') }}</button>
                </div>

            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const excursions = @json($excursions->load('days.times'));
            const selectedTimes = @json($selectedExcursions->mapWithKeys(fn($e) => [$e->id => $e->pivot->excursion_time_id]));

            function calc() {
                let t = 0;
                document.querySelectorAll('.excursion-checkbox:checked')
                    .forEach(c => t += parseFloat(c.dataset.price));
                document.getElementById('totalPrice').innerText = t.toFixed(2);
            }

            function fillTimes(excId, dayId, select) {
                select.innerHTML = '<option value="">Time</option>';
                let ex = excursions.find(e => e.id == excId);
                let day = ex?.days.find(d => d.id == dayId);
                day?.times.forEach(time => {
                    let o = document.createElement('option');
                    o.value = time.id;
                    o.textContent = time.from_time + ' - ' + time.to_time;
                    select.appendChild(o);
                });
                if (selectedTimes[excId]) select.value = selectedTimes[excId];
            }

            document.querySelectorAll('.excursion-checkbox').forEach(cb => {
                let id = cb.value;
                let daySel = document.getElementById('day-' + id);
                let timeSel = document.getElementById('time-' + id);

                cb.addEventListener('change', () => {
                    daySel.disabled = !cb.checked;
                    if (!cb.checked) {
                        daySel.value = '';
                        timeSel.innerHTML = '<option value="">Time</option>';
                        timeSel.disabled = true;
                    }
                    calc();
                });
            });

            document.querySelectorAll('.excursion-day-select').forEach(sel => {
                sel.addEventListener('change', function() {
                    let id = this.dataset.excursionId;
                    let timeSel = document.getElementById('time-' + id);
                    timeSel.disabled = false;
                    fillTimes(id, this.value, timeSel);
                });
            });

            calc();
        });
    </script>
@endpush

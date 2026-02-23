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
                    $selectedExcursions = $offer->excursions()->withPivot('excursion_time_id')->get();
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
                                        value="{{ old('start_date', optional($offer->start_date)->format('Y-m-d')) }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>{{ __('End Date') }}</label>
                                    <input type="date" name="end_date"
                                        value="{{ old('end_date', optional($offer->end_date)->format('Y-m-d')) }}"
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
                                            <span
                                                class="badge bg-success">${{ number_format($excursion->price, 2) }}</span>
                                        </div>

                                        {{--  <select name="times[{{ $excursion->id }}][]" id="time-{{ $excursion->id }}"
                                            class="form-select form-select-sm mt-2" multiple
                                            {{ $pivot ? '' : 'disabled' }}>

                                            @foreach ($excursion->times as $time)
                                                <option value="{{ $time->id }}"
                                                    {{ in_array(
                                                        $time->id,
                                                        old(
                                                            "times.$excursion->id",
                                                            $selectedExcursions->where('id', $excursion->id)->pluck('pivot.excursion_time_id')->toArray(),
                                                        ),
                                                    )
                                                        ? 'selected'
                                                        : '' }}>
                                                    {{ $time->from_time }} - {{ $time->to_time }}
                                                </option>
                                            @endforeach
                                        </select>  --}}

                                    </div>
                                </div>
                            @endforeach

                        </div>

                         <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ __('Times') }}</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addTime()">
                                + {{ __('Add Time') }}
                            </button>
                        </div>

                        <div class="card-body" id="times-wrapper"></div>
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

            function calc() {
                let total = 0;
                document.querySelectorAll('.excursion-checkbox:checked')
                    .forEach(cb => total += parseFloat(cb.dataset.price));
                document.getElementById('totalPrice').innerText = total.toFixed(2);
            }

            document.querySelectorAll('.excursion-checkbox').forEach(cb => {
                const id = cb.value;
                const timeSelect = document.getElementById('time-' + id);

                timeSelect.disabled = !cb.checked;

                cb.addEventListener('change', function() {
                    timeSelect.disabled = !this.checked;
                    if (!this.checked) {
                        [...timeSelect.options].forEach(o => o.selected = false);
                    }
                    calc();
                });
            });

            calc();
        });

        let timeIndex = 0;

        {{--  document.addEventListener('DOMContentLoaded', function() {
            const oldTimes = @json($preparedTimes);

            oldTimes.forEach(time => {
                addTime(time);
            });
        });  --}}

        function addTime(data = null) {
            const wrapper = document.getElementById('times-wrapper');

            function to24Hour(time12h) {
                if (!time12h) return '';
                const [time, modifier] = time12h.split(' ');
                let [hours, minutes] = time.split(':');
                if (modifier === 'PM' && hours !== '12') hours = parseInt(hours) + 12;
                if (modifier === 'AM' && hours === '12') hours = '00';
                return `${hours.toString().padStart(2,'0')}:${minutes}`;
            }

            let fromVal = to24Hour(data?.from_time ?? '');
            let toVal = to24Hour(data?.to_time ?? '');

            let html = `
    <div class="row g-2 mb-2 align-items-end time-block">
        <div class="col-md-5">
            <label class="form-label">From Time</label>
            <input type="time"
                   name="times[${timeIndex}][from_time]"
                   class="form-control"
                   value="${fromVal}"
                   required>
        </div>
        <div class="col-md-5">
            <label class="form-label">To Time</label>
            <input type="time"
                   name="times[${timeIndex}][to_time]"
                   class="form-control"
                   value="${toVal}"
                   required>
        </div>
        <div class="col-md-2 d-flex justify-content-end">
            <button type="button"
                    class="btn btn-danger w-100"
                    onclick="this.closest('.time-block').remove()">
                X
            </button>
        </div>
    </div>
    `;

            wrapper.insertAdjacentHTML('beforeend', html);
            timeIndex++;
        }
    </script>
@endpush

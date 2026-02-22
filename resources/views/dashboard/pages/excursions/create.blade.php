@extends('dashboard.layouts.app')
@section('title', __('Add Excursion'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0">{{ __('Add Excursion') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.excursions.index') }}">{{ __('Excursions') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Add Excursion') }}</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('Admin.excursions.store') }}" enctype="multipart/form-data">
                @csrf

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
                        <h6 class="mb-0">{{ __('Excursion Translations') }}</h6>
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
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="lang-{{ $key }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Name ({{ $lang }})</label>
                                            <input type="text" name="name[{{ $key }}]"
                                                value="{{ old("name.$key") }}" class="form-control">
                                            @error("name.$key")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Description ({{ $lang }})</label>
                                            <input type="text" name="description[{{ $key }}]"
                                                value="{{ old("description.$key") }}" class="form-control">
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
                                <h6 class="mb-0">{{ __('Excursion Information') }}</h6>
                            </div>
                            <div class="card-body row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <input type="text" name="price" value="{{ old('price') }}" class="form-control">
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Hours') }}</label>
                                    <input type="text" name="hours" value="{{ old('hours') }}" class="form-control">
                                    @error('hours')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Category') }}</label>
                                    <select name="category_excursion_id" id="category_excursion" class="form-select">
                                        <option value="">{{ __('Choose...') }}</option>
                                        @foreach ($category_excursions as $category)
                                            <option value="{{ $category->id }}">
                                                {{ data_get($category->name, app()->getLocale(), $category->name['en']) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('category_excursion_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Sub Category') }}</label>
                                    <select name="sub_category_excursion_id" id="sub_category_excursion"
                                        class="form-select">
                                        <option value="">{{ __('Choose category first') }}</option>
                                    </select>

                                    @error('sub_category_excursion_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('City') }}</label>
                                    <select name="city_id" class="form-select">
                                        <option value="">{{ __('Choose...') }}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ data_get($city->name, app()->getLocale(), $city->name['en']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
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
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <label class="form-label">{{ __('Status') }}</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>
                                        {{ __('Active') }}
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                        {{ __('UnActive') }}
                                    </option>
                                </select>
                                @error('is_active')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                    </div>



                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light d-flex justify-content-between">
                            <h6 class="mb-0">{{ __('Times') }}</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addTime()">
                                + {{ __('Add Time') }}
                            </button>
                        </div>

                        <div class="card-body" id="times-wrapper">
                        </div>
                    </div>
                </div>


                <div class="text-end mb-5">
                    <button class="btn btn-primary px-5">
                        <i class="ti ti-device-floppy"></i> {{ __('Save Excursion') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('category_excursion').addEventListener('change', function() {

            let categoryId = this.value;
            let subSelect = document.getElementById('sub_category_excursion');

            subSelect.innerHTML = '<option>Loading...</option>';

            if (!categoryId) {
                subSelect.innerHTML = '<option>Choose category first</option>';
                return;
            }

            fetch("{{ route('Admin.get.sub.categories', '__id__') }}".replace('__id__', categoryId))
                .then(response => response.json())
                .then(data => {
                    subSelect.innerHTML = '<option value="">Choose...</option>';

                    data.forEach(sub => {
                        let name = sub.name['{{ app()->getLocale() }}'] ?? sub.name.en;
                        let option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = name;
                        subSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    subSelect.innerHTML = '<option>Error loading data</option>';
                });
        });
    </script>
    <script>
        let timeIndex = 0;

        function addTime() {
            const wrapper = document.getElementById('times-wrapper');

            let html = `

           <div class="row g-2 mb-2 align-items-end time-block">

    <div class="col-md-5">
        <label class="form-label">{{ __('From Time') }}</label>
        <input type="time"
               name="times[${timeIndex}][from_time]"
               class="form-control"
               required>
    </div>

    <div class="col-md-5">
        <label class="form-label">{{ __('To Time') }}</label>
        <input type="time"
               name="times[${timeIndex}][to_time]"
               class="form-control"
               required>
    </div>

    <div class="col-md-2">
        <label class="form-label d-block">&nbsp;</label>
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

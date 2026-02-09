@extends('dashboard.layouts.app')
@section('title', __('Excursion Details'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Excursion Details') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.excursions.index') }}">{{ __('Excursions') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ data_get($excursion->name, app()->getLocale(), $excursion->name['en']) }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg bg-white">

                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                {{ data_get($excursion->name, app()->getLocale(), $excursion->name['en']) }}
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-4">

                                <!-- Image -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('Image') }}</label>
                                    <div>
                                        <img src="{{ asset($excursion->image) }}" class="img-fluid rounded shadow w-50"
                                            alt="excursion image">
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="col-md-8">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Price') }}</label>
                                            <p class="mb-0">{{ $excursion->price }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Hours') }}</label>
                                            <p class="mb-0">{{ $excursion->hours }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Category') }}</label>
                                            <p class="mb-0">
                                                {{ data_get($excursion->categoryExcursion->name, app()->getLocale(), $excursion->categoryExcursion->name['en']) }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('SubCategory') }}</label>
                                            <p class="mb-0">
                                                {{ data_get($excursion->subcategoryExcursion->name, app()->getLocale(), $excursion->subcategoryExcursion->name['en']) ?? '' }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('City') }}</label>
                                            <p class="mb-0">
                                                {{ data_get($excursion->city->name, app()->getLocale(), $excursion->city->name['en']) }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Status') }}</label>
                                            <p class="mb-0">
                                                @if ($excursion->is_active)
                                                    <span class="badge bg-success">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('UnActive') }}</span>
                                                @endif
                                            </p>
                                        </div>

                                    </div>
                                </div>

                                <!-- Descriptions -->
                                <div class="col-12">
                                    <hr>
                                    <label class="fw-bold">{{ __('Description') }}</label>
                                    <p class="mt-2">
                                        {{ data_get($excursion->description, app()->getLocale(), $excursion->description['en']) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        

                        <div class="col-12 mt-4">
                            <hr>
                            <label class="fw-bold">{{ __('Days & Times') }}</label>

                            @if ($excursion->days && $excursion->days->count())
                                <div class="mt-3">
                                    @foreach ($excursion->days as $day)
                                        <div class="mb-3">
                                            <h6>{{ $day->day }}</h6>
                                            @if ($day->times && $day->times->count())
                                                <ul class="list-group">
                                                    @foreach ($day->times as $time)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center p-2">
                                                            <span>{{ __('From') }}:
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->from_time)->format('H:i') }}</span>
                                                            <span>{{ __('To') }}:
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->to_time)->format('H:i') }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p><em>{{ __('No times set for this day.') }}</em></p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p><em>{{ __('No days or times available for this excursion.') }}</em></p>
                            @endif
                        </div>


                        <div class="card-footer text-end bg-light">
                            <a href="{{ route('Admin.excursions.index') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

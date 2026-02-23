@extends('dashboard.layouts.app')
@section('title', __('Show Offer'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb mb-2">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}"><i class="ti ti-home"></i>
                                        {{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.offers.index') }}">{{ __('Offers') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Offer Details') }}</li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold">{{ __('Offer Details') }}: <span
                                        class="text-primary">#{{ $offer->id }}</span></h5>
                                <a href="{{ route('Admin.offers.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="ti ti-arrow-narrow-left"></i> {{ __('Back to Offers') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-bold text-dark"><i
                                    class="ti ti-language me-2 text-primary"></i>{{ __('Offer Content & Translations') }}
                            </h6>
                        </div>
                        <div class="card-body">
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

                            <ul class="nav nav-pills nav-fill mb-4 bg-light p-1 rounded shadow-sm" role="tablist">
                                @foreach ($langs as $key => $lang)
                                    <li class="nav-item">
                                        <a href="#lang-{{ $key }}"
                                            class="nav-link py-2 {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab">
                                            {{ $lang }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content p-2">
                                @foreach ($langs as $key => $lang)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="lang-{{ $key }}">
                                        <div class="mb-3">
                                            <label
                                                class="form-label fw-bold text-muted small uppercase">{{ __('Name') }}</label>
                                            <h4 class="text-dark">{{ data_get($offer->name, $key) ?: '---' }}</h4>
                                        </div>
                                        <hr class="opacity-25">
                                        <div class="mb-0">
                                            <label
                                                class="form-label fw-bold text-muted small uppercase">{{ __('Description') }}</label>
                                            <p class="text-muted lh-base">
                                                {{ data_get($offer->description, $key) ?: '---' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div
                            class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-dark"><i
                                    class="ti ti-map-pin me-2 text-primary"></i>{{ __('Selected Excursions') }}</h6>
                            <span class="badge bg-light-primary text-primary">{{ $offer->excursions->count() }}
                                {{ __('Items') }}</span>
                        </div>
                        <div class="card-body">
                            @if ($offer->excursions->count())
                                <div class="row g-3">
                                    @foreach ($offer->excursions as $excursion)
                                        <div class="col-md-6">
                                            <div class="card border p-3 h-100 bg-light-alt transition-hover">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h6 class="fw-bold mb-0">
                                                        {{ $excursion->name[app()->getLocale()] ?? $excursion->name['en'] }}
                                                    </h6>
                                                    <span
                                                        class="text-primary fw-bold small">${{ number_format($excursion->price, 2) }}</span>
                                                </div>
                                                <div class="small">
                                                    <div class="mb-1 text-muted"><i class="ti ti-map-2 me-1"></i>
                                                        {{ $excursion->city->name[app()->getLocale()] ?? '-' }}</div>
                                                    <div class="mb-1 text-muted"><i class="ti ti-clock me-1"></i>
                                                        {{ $excursion->hours ?? '-' }} {{ __('Hours') }}</div>
                                                    <div class="mt-2 p-2 bg-white rounded border border-dashed">
                                                        @foreach ($excursion->times as $time)
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span><i class="ti ti-alarm me-1"></i>
                                                                    {{ $time->from_time }} - {{ $time->to_time }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="ti ti-circle-x text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted">{{ __('No excursions selected') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    @if ($offer->is_active)
                                        <span class="badge bg-light-success text-success px-3 py-2 fs-6 w-100"><i
                                                class="ti ti-circle-check me-1"></i> {{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger px-3 py-2 fs-6 w-100"><i
                                                class="ti ti-circle-x me-1"></i> {{ __('Inactive') }}</span>
                                    @endif
                                </div>
                                <h2 class="fw-bold text-primary mb-0">${{ number_format($offer->price, 2) }}</h2>
                                <p class="text-muted small">{{ __('Total Offer Price') }}</p>
                            </div>

                            <div class="list-group list-group-flush border-top">
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                    <span class="text-muted small fw-bold text-uppercase"><i
                                            class="ti ti-calendar-up me-1"></i> {{ __('Start Date') }}</span>
                                    <span
                                        class="fw-bold">{{ $offer->start_date ? $offer->start_date->format('Y-m-d') : '-' }}</span>
                                </div>
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-bottom-0">
                                    <span class="text-muted small fw-bold text-uppercase"><i
                                            class="ti ti-calendar-down me-1"></i> {{ __('End Date') }}</span>
                                    <span
                                        class="fw-bold">{{ $offer->end_date ? $offer->end_date->format('Y-m-d') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 fw-bold text-dark"><i
                                    class="ti ti-photo me-2 text-primary"></i>{{ __('Offer Image') }}</h6>
                        </div>
                        <div class="card-body text-center p-2">
                            @if ($offer->image)
                                <img src="{{ asset('storage/excursion/' . $offer->image) }}" alt="Offer Image"
                                    class="img-fluid rounded shadow-sm w-100" style="object-fit: cover; max-height: 250px;">
                            @else
                                <div class="bg-light rounded py-5">
                                    <i class="ti ti-photo-off text-muted opacity-50" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 small">{{ __('No Image Available') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .bg-light-alt {
            background-color: #f8f9fa !important;
        }

        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1) !important;
        }

        .bg-light-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .bg-light-primary {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .transition-hover:hover {
            transform: translateY(-3px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
            border-color: var(--bs-primary) !important;
        }

        .nav-pills .nav-link.active {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endsection

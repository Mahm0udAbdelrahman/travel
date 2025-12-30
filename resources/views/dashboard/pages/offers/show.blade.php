@extends('dashboard.layouts.app')
@section('title', __('Show Offer'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="page-block">
                <div class="page-header-title">
                    <h4 class="mb-0">{{ __('Show Offer') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.offers.index') }}">{{ __('Offers') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Show Offer') }}</li>
                </ul>
            </div>
        </div>

        {{-- Offer Card --}}
        <div class="card shadow-sm border-0 mb-5">
            <div class="row g-0">
                @if($offer->image)
                <div class="col-md-4">
                    <img src="{{ asset($offer->image) }}" alt="Offer Image" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;">
                </div>
                @endif

                <div class="{{ $offer->image ? 'col-md-8' : 'col-md-12' }}">
                    <div class="card-body">
                        <h3 class="card-title mb-3">
                            {{ $offer->name[app()->getLocale()] ?? $offer->name['en'] }}
                        </h3>

                        {{-- Description --}}
                        <h6 class="text-muted">{{ __('Description') }}</h6>
                        <p class="mb-4">{{ $offer->description[app()->getLocale()] ?? $offer->description['en'] }}</p>

                        {{-- Price and Dates --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <h5 class="mb-1">${{ number_format($offer->price, 2) }}</h5>
                                    <small class="text-muted">{{ __('Price') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <h6 class="mb-1">{{ \Carbon\Carbon::parse($offer->start_date)->format('M d, Y') }}</h6>
                                    <small class="text-muted">{{ __('Start Date') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <h6 class="mb-1">{{ \Carbon\Carbon::parse($offer->end_date)->format('M d, Y') }}</h6>
                                    <small class="text-muted">{{ __('End Date') }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <p>
                            <span class="badge {{ $offer->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $offer->is_active ? __('Active') : __('UnActive') }}
                            </span>
                        </p>

                        {{-- Excursions --}}
                        <h5 class="mt-4">{{ __('Excursions') }}</h5>
                        @if($offer->excursions->isEmpty())
                            <p class="text-muted">{{ __('No excursions selected.') }}</p>
                        @else
                            <ul class="list-group list-group-flush mb-3">
                                @foreach ($offer->excursions as $excursion)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $excursion->name[app()->getLocale()] ?? $excursion->name['en'] }}
                                            <br>
                                            <small class="text-muted">{{ $excursion->hours ?? '-' }} {{ __('Hours') }}</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">${{ number_format($excursion->price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-flex justify-content-end">
                                <h6>
                                    {{ __('Total Excursions Price') }}: 
                                    <span class="text-primary fw-bold">
                                        ${{ number_format($offer->excursions->sum('price'), 2) }}
                                    </span>
                                </h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('Admin.offers.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back to Offers') }}
        </a>

    </div>
</div>
@endsection

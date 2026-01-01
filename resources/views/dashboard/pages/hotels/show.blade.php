@extends('dashboard.layouts.app')
@section('title', __('Show Hotel'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="page-header-title">
                        <h4 class="mb-0">{{ __('Show Hotel') }}</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.hotels.index') }}">{{ __('Hotels') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Show Hotel') }}</li>
                    </ul>
                </div>
            </div>

            {{-- Hotel Card --}}
            <div class="card shadow-sm border-0 mb-5">
                <div class="row g-0">
                    @if ($hotel->image)
                        <div class="col-md-4">
                            <img src="{{ asset($hotel->image) }}" alt="Hotel Image" class="img-fluid rounded-start"
                                style="height: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="{{ $hotel->image ? 'col-md-8' : 'col-md-12' }}">
                        <div class="card-body">
                            <h3 class="card-title mb-3">
                                {{ $hotel->name[app()->getLocale()] ?? $hotel->name['en'] }}
                            </h3>

                            {{-- Status --}}
                            <p>
                                <span class="badge {{ $offer->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $offer->is_active ? __('Active') : __('UnActive') }}
                                </span>
                            </p>


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

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

            {{-- Tour Leaders --}}
            <section>
                <h5 class="mb-3">{{ __('Tour Leaders') }}</h5>

                @if ($hotel->tourLeaders->isEmpty())
                    <p class="fst-italic text-secondary">{{ __('No tour leaders selected.') }}</p>
                @else
                    <div class="row g-4">
                        @foreach ($hotel->tourLeaders as $tourLeader)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div
                                    class="card shadow-sm h-100 border-0 rounded-3
                            bg-white hover-shadow cursor-pointer">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary fw-bold mb-2"><a
                                                href="{{ route('Admin.users.show', $tourLeader->id) }}"
                                                class="text-decoration-none">{{ $tourLeader->name }}</a></h6>
                                        <p class="card-text text-muted fst-italic mb-0">
                                            {{ $tourLeader->type->label() ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <a href="{{ route('Admin.offers.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left"></i> {{ __('Back to Offers') }}
            </a>

        </div>
    </div>
@endsection

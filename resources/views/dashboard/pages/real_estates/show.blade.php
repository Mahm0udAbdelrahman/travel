@extends('dashboard.layouts.app')
@section('title', __('Real Estate Details'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Real Estate Details') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.real_estates.index') }}">{{ __('Real Estates') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ data_get($realEstate->name, app()->getLocale(), $realEstate->name['en']) }}
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
                                {{ data_get($realEstate->name, app()->getLocale(), $realEstate->name['en']) }}
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-4">

                                <!-- Image -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('Image') }}</label>
                                    <div>
                                        <img src="{{ asset($realEstate->image) }}" class="img-fluid rounded shadow"
                                            alt="real estate image">
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="col-md-8">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Price') }}</label>
                                            <p class="mb-0">{{ $realEstate->price }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Date') }}</label>
                                            <p class="mb-0">{{ $realEstate->date }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Category') }}</label>
                                            <p class="mb-0">
                                                {{ data_get($realEstate->categoryRealEstate->name, app()->getLocale(), $realEstate->categoryRealEstate->name['en']) }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('City') }}</label>
                                            <p class="mb-0">
                                                {{ data_get($realEstate->city->name, app()->getLocale(), $realEstate->city->name['en']) }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fw-bold">{{ __('Status') }}</label>
                                            <p class="mb-0">
                                                @if ($realEstate->is_active)
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
                                        {{ data_get($realEstate->description, app()->getLocale(), $realEstate->description['en']) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end bg-light">
                            <a href="{{ route('Admin.real_estates.index') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

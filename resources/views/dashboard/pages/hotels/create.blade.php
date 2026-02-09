@extends('dashboard.layouts.app')
@section('title', __('Add Hotel'))
@push('styles')
    <style>
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
    </style>
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0">{{ __('Add Hotel') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.hotels.index') }}">{{ __('Hotels') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Add Hotel') }}</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('Admin.hotels.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- English Name Only --}}
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">{{ __('Hotel Name') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name (English)</label>
                                <input type="text" name="name[en]" value="{{ old('name.en') }}" class="form-control" placeholder="Enter hotel name">
                                @error('name.en')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Info --}}
                <div class="row">

                    {{-- Settings --}}
                    <div class="col-md-12">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ __('Settings') }}</h6>
                            </div>
                            <div class="card-body">

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
                </div>

                {{-- Select Tour Leaders --}}
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h6 class="mb-0">
                            <i class="ti ti-map-pin text-primary"></i> Select Tour Leaders
                        </h6>

                        <div class="d-flex gap-2 align-items-center">
                            <input type="text" id="fileSearch" class="form-control form-control-sm" placeholder="Search...">

                            <button type="button" id="selectAll" class="btn btn-sm btn-outline-primary">
                                Select All
                            </button>

                            <button type="button" id="clearAll" class="btn btn-sm btn-outline-secondary">
                                Clear
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="max-height: 450px; overflow:auto">
                        <div class="row g-3">

                            @foreach ($tourLeaders as $tourLeader)
                                <div class="col-md-6 file-item" data-category="{{ $tourLeader->type->value }}" data-name="{{ strtolower($tourLeader->name) }}">
                                    <label class="card h-100 p-3 file-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $tourLeader->name }}</h6>
                                                <small class="text-muted">
                                                    {{ $tourLeader->type->label() }}
                                                </small>
                                            </div>
                                            <input class="form-check-input file-checkbox" type="checkbox" value="{{ $tourLeader->id }}" name="tour_leader_ids[]">
                                        </div>
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="text-end mb-5">
                    <button class="btn btn-primary px-5">
                        <i class="ti ti-device-floppy"></i> {{ __('Save Hotel') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

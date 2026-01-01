@extends('dashboard.layouts.app')
@section('title', __('Edit Hotel'))
@push('styles')
<style>
    .excursion-card {
        transition: all .2s ease;
        cursor: pointer;
    }
    .excursion-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,.08);
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
                    <h5 class="mb-0">{{ __('Edit Hotel') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.hotels.index') }}">{{ __('Hotels') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Edit Hotel') }}</li>
                </ul>
            </div>
        </div>

        <form method="POST" action="{{ route('Admin.hotels.update', $hotel->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                    <h6 class="mb-0">{{ __('Hotel Translations') }}</h6>
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
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name ({{ $lang }})</label>
                                        <input type="text" name="name[{{ $key }}]"
                                             value="{{ old("name.$key", data_get($hotel->name, $key)) }}"
                                            class="form-control">
                                        @error("name.$key")
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

                {{-- Settings --}}
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{ __('Settings') }}</h6>
                        </div>
                        <div class="card-body">



                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active', $hotel->is_active) == '1' ? 'selected' : '' }}>
                                    {{ __('Active') }}
                                </option>
                                <option value="0" {{ old('is_active', $hotel->is_active) == '0' ? 'selected' : '' }}>
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


            {{-- Submit --}}
            <div class="text-end mb-5">
                <button class="btn btn-primary px-5">
                    <i class="ti ti-device-floppy"></i> {{ __('Update Hotel') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection



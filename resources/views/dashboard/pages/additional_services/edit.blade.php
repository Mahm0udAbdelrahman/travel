@extends('dashboard.layouts.app')
@section('title', __('Edit Additional Service'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Edit Additional Service') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('Admin.additional_services.index') }}">{{ __('Additional Services') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Edit Additional Service') }}</li>
                    </ul>
                </div>
            </div>

            @php
                $langs = [
                    'ar' => 'Arabic', 'en' => 'English', 'es' => 'Spanish', 'it' => 'Italian',
                    'de' => 'German', 'ja' => 'Japanese', 'zh' => 'Chinese', 'ru' => 'Russian', 'fr' => 'French'
                ];
            @endphp

            <form method="post" action="{{ route('Admin.additional_services.update', $additional_service->id) }}"
                enctype="multipart/form-data" class="p-3 rounded shadow-lg bg-white">
                @csrf
                @method('PUT')

                <div class="card border-0">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0">{{ __('Edit Additional Service') }}</h5>
                    </div>

                    <div class="card-body">

                        {{-- Language Tabs --}}
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            @foreach ($langs as $key => $lang)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}"
                                        data-bs-toggle="tab" data-bs-target="#lang-{{ $key }}" type="button"
                                        role="tab" aria-controls="lang-{{ $key }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $lang }}</button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach ($langs as $key => $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}"
                                    role="tabpanel" aria-labelledby="tab-{{ $key }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name_{{ $key }}" class="form-label">{{ __('Name') }} ({{ $lang }})</label>
                                            <input type="text" name="name[{{ $key }}]" id="name_{{ $key }}"
                                                value="{{ old("name.$key", data_get($additional_service->name, $key, '')) }}"
                                                class="form-control"
                                                placeholder="{{ __('Enter the additional service name') }}">
                                            @error("name.$key")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="description_{{ $key }}" class="form-label">{{ __('Description') }} ({{ $lang }})</label>
                                            <input type="text" name="description[{{ $key }}]" id="description_{{ $key }}"
                                                value="{{ old("description.$key", data_get($additional_service->description, $key, '')) }}"
                                                class="form-control"
                                                placeholder="{{ __('Enter the additional service description') }}">
                                            @error("description.$key")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- باقي الحقول خارج التابز --}}
                        <div class="row g-3 mt-4">

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Image') }}</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                {{-- عرض الصورة الحالية --}}
                                @if($additional_service->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($additional_service->image) }}" alt="Current Image" style="max-width: 150px; max-height: 150px; border-radius: 6px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
                                <select class="form-select" name="is_active" id="is_active">
                                    <option value="" disabled>{{ __('Choose is_active...') }}</option>
                                    <option value="0"
                                        {{ old('is_active', $additional_service->is_active) == 0 ? 'selected' : '' }}>
                                        {{ __('UnActive') }}</option>
                                    <option value="1"
                                        {{ old('is_active', $additional_service->is_active) == 1 ? 'selected' : '' }}>
                                        {{ __('Active') }}</option>
                                </select>
                                @error('is_active')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end bg-light rounded-bottom">
                        <button type="submit" class="btn btn-primary px-4">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

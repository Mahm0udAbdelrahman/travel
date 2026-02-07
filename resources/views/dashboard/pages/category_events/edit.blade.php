@extends('dashboard.layouts.app')
@section('title', __('Edit Category Event'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Edit Category Event') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('Admin.category_events.index') }}">{{ __('Category Events') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Edit Category Event') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="post" action="{{ route('Admin.category_events.update', $category_event->id) }}"
                        enctype="multipart/form-data" class="p-3 rounded shadow-lg bg-white">
                        @csrf
                        @method('PUT')

                        <div class="card border-0">
                            <div class="card-header bg-primary text-white rounded-top">
                                <h5 class="mb-0">{{ __('Edit Category Event') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label for="name_ar" class="form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name[ar]" id="name_ar"
                                            value="{{ old('name.ar', data_get($category_event->name, 'ar', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the category event name') }}">
                                        @error('name.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_en" class="form-label">{{ __('Name EN') }}</label>
                                        <input type="text" name="name[en]" id="name_en"
                                            value="{{ old('name.en', data_get($category_event->name, 'en', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the category event name') }}">
                                        @error('name.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_es" class="form-label">{{ __('Name Es') }}</label>
                                        <input type="text" name="name[es]" id="name_es"
                                            value="{{ old('name.es', data_get($category_event->name, 'es', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the category event name') }}">
                                        @error('name.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_it" class="form-label">{{ __('Name It') }}</label>
                                        <input type="text" name="name[it]" id="name_it"
                                            value="{{ old('name.it', data_get($category_event->name, 'it', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the category event name') }}">
                                        @error('name.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name De</label>
                                        <input type="text" name="name[de]"
                                            value="{{ old('name.de', data_get($category_event->name, 'de')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ja</label>
                                        <input type="text" name="name[ja]"
                                            value="{{ old('name.ja', data_get($category_event->name, 'ja')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Zh</label>
                                        <input type="text" name="name[zh]"
                                            value="{{ old('name.zh', data_get($category_event->name, 'zh')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ru</label>
                                        <input type="text" name="name[ru]"
                                            value="{{ old('name.ru', data_get($category_event->name, 'ru')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Fr</label>
                                        <input type="text" name="name[fr]"
                                            value="{{ old('name.fr', data_get($category_event->name, 'fr')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Image') }}</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @if ($category_event->image)
                                            <div class="mt-2">
                                                <img src="{{ asset($category_event->image) }}" alt="Current Image"
                                                    style="max-width: 150px; max-height: 150px; border-radius: 6px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
                                        <select class="form-select" name="is_active" id="is_active">
                                            <option value="" disabled>{{ __('Choose is_active...') }}</option>
                                            <option value="0"
                                                {{ old('is_active', $category_event->is_active) == 0 ? 'selected' : '' }}>
                                                {{ __('UnActive') }}</option>
                                            <option value="1"
                                                {{ old('is_active', $category_event->is_active) == 1 ? 'selected' : '' }}>
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

        </div>
    </div>
@endsection

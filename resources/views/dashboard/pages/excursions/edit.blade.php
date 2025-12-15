@extends('dashboard.layouts.app')
@section('title', __('Edit Excursion'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Edit Excursion') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('Admin.excursions.index') }}">{{ __('Excursions') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Edit Excursion') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="post" action="{{ route('Admin.excursions.update', $excursion->id) }}"
                        enctype="multipart/form-data" class="p-3 rounded shadow-lg bg-white">
                        @csrf
                        @method('PUT')

                        <div class="card border-0">
                            <div class="card-header bg-primary text-white rounded-top">
                                <h5 class="mb-0">{{ __('Edit Excursion') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label for="name_ar" class="form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name[ar]" id="name_ar"
                                            value="{{ old('name.ar', data_get($excursion->name, 'ar', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the excursion name') }}">
                                        @error('name.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_en" class="form-label">{{ __('Name EN') }}</label>
                                        <input type="text" name="name[en]" id="name_en"
                                            value="{{ old('name.en', data_get($excursion->name, 'en', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the excursion name') }}">
                                        @error('name.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_es" class="form-label">{{ __('Name Es') }}</label>
                                        <input type="text" name="name[es]" id="name_es"
                                            value="{{ old('name.es', data_get($excursion->name, 'es', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the excursion name') }}">
                                        @error('name.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_it" class="form-label">{{ __('Name It') }}</label>
                                        <input type="text" name="name[it]" id="name_it"
                                            value="{{ old('name.it', data_get($excursion->name, 'it', '')) }}"
                                            class="form-control" placeholder="{{ __('Enter the excursion name') }}">
                                        @error('name.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name De</label>
                                        <input type="text" name="name[de]"
                                            value="{{ old('name.de', data_get($excursion->name, 'de')) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ja</label>
                                        <input type="text" name="name[ja]"
                                            value="{{ old('name.ja', data_get($excursion->name, 'ja')) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Zh</label>
                                        <input type="text" name="name[zh]"
                                            value="{{ old('name.zh', data_get($excursion->name, 'zh')) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ru</label>
                                        <input type="text" name="name[ru]"
                                            value="{{ old('name.ru', data_get($excursion->name, 'ru')) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Fr</label>
                                        <input type="text" name="name[fr]"
                                            value="{{ old('name.fr', data_get($excursion->name, 'fr')) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control">
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
                                        <select class="form-select" name="is_active" id="is_active">
                                            <option value="" disabled>{{ __('Choose is_active...') }}</option>
                                            <option value="0"
                                                {{ old('is_active', $excursion->is_active) == 0 ? 'selected' : '' }}>
                                                {{ __('UnActive') }}</option>
                                            <option value="1"
                                                {{ old('is_active', $excursion->is_active) == 1 ? 'selected' : '' }}>
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

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

            <!-- Main Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="post" action="{{ route('Admin.additional_services.update', $additional_service->id) }}"
                        enctype="multipart/form-data" class="p-3 rounded shadow-lg bg-white">
                        @csrf
                        @method('PUT')

                        <div class="card border-0">
                            <div class="card-header bg-primary text-white rounded-top">
                                <h5 class="mb-0">{{ __('Edit Additional Service') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label for="name_ar" class="form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name[ar]" id="name_ar"
                                            value="{{ old('name.ar', data_get($additional_service->name, 'ar', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the additional_service name') }}">
                                        @error('name.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_en" class="form-label">{{ __('Name EN') }}</label>
                                        <input type="text" name="name[en]" id="name_en"
                                            value="{{ old('name.en', data_get($additional_service->name, 'en', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the additional_service name') }}">
                                        @error('name.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_es" class="form-label">{{ __('Name Es') }}</label>
                                        <input type="text" name="name[es]" id="name_es"
                                            value="{{ old('name.es', data_get($additional_service->name, 'es', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the additional_service name') }}">
                                        @error('name.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_it" class="form-label">{{ __('Name It') }}</label>
                                        <input type="text" name="name[it]" id="name_it"
                                            value="{{ old('name.it', data_get($additional_service->name, 'it', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the additional_service name') }}">
                                        @error('name.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name De</label>
                                        <input type="text" name="name[de]"
                                            value="{{ old('name.de', data_get($additional_service->name, 'de')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ja</label>
                                        <input type="text" name="name[ja]"
                                            value="{{ old('name.ja', data_get($additional_service->name, 'ja')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Zh</label>
                                        <input type="text" name="name[zh]"
                                            value="{{ old('name.zh', data_get($additional_service->name, 'zh')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ru</label>
                                        <input type="text" name="name[ru]"
                                            value="{{ old('name.ru', data_get($additional_service->name, 'ru')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Fr</label>
                                        <input type="text" name="name[fr]"
                                            value="{{ old('name.fr', data_get($additional_service->name, 'fr')) }}"
                                            class="form-control">
                                    </div>


                                    <div class="col-md-6">
                                        <label for="description_ar" class="form-label">{{ __('Description Ar') }}</label>
                                        <input type="text" name="description[ar]" id="description_ar"
                                            value="{{ old('description.ar', data_get($additional_service->description, 'ar')) }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('description.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="description_en" class="form-label">{{ __('Description En') }}</label>
                                        <input type="text" name="description[en]" id="description_en"
                                            value="{{ old('description.en', data_get($additional_service->description, 'en')) }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('description.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="description_es" class="form-label">{{ __('Description Es') }}</label>
                                        <input type="text" name="description[es]" id="description_es"
                                            value="{{ old('description.es', data_get($additional_service->description, 'es')) }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('description.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="description_it" class="form-label">{{ __('Description It') }}</label>
                                        <input type="text" name="description[it]" id="description_it"
                                            value="{{ old('description.it', data_get($additional_service->description, 'it')) }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('description.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description De</label>
                                        <input type="text" name="description[de]"
                                            value="{{ old('description.de', data_get($additional_service->description, 'de')) }}"
                                            class="form-control">
                                        @error('description.de')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description Ja</label>
                                        <input type="text" name="description[ja]"
                                            value="{{ old('description.ja', data_get($additional_service->description, 'ja')) }}"
                                            class="form-control">
                                        @error('description.ja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description Zh</label>
                                        <input type="text" name="description[zh]"
                                            value="{{ old('description.zh', data_get($additional_service->description, 'zh')) }}"
                                            class="form-control">
                                        @error('description.zh')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description Ru</label>
                                        <input type="text" name="description[ru]"
                                            value="{{ old('description.ru', data_get($additional_service->description, 'ru')) }}"
                                            class="form-control">
                                        @error('description.ru')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description Fr</label>
                                        <input type="text" name="description[fr]"
                                            value="{{ old('description.fr', data_get($additional_service->description, 'fr')) }}"
                                            class="form-control">
                                        @error('description.fr')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
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

        </div>
    </div>
@endsection

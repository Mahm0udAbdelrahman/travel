@extends('dashboard.layouts.app')
@section('title', __('Edit Sub Category Excursion'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Edit Category Excursion') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('Admin.sub_category_excursions.index') }}">{{ __('Sub Category Excursions') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Edit Sub Category Excursion') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="post" action="{{ route('Admin.sub_category_excursions.update', $sub_category_excursions->id) }}"
                        enctype="multipart/form-data" class="p-3 rounded shadow-lg bg-white">
                        @csrf
                        @method('PUT')

                        <div class="card border-0">
                            <div class="card-header bg-primary text-white rounded-top">
                                <h5 class="mb-0">{{ __('Edit Sub Category Excursion') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Category') }}</label>
                                        <select name="category_excursion_id" class="form-select">
                                            <option value="">{{ __('Choose...') }}</option>
                                            @foreach ($category_excursions as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_excursion_id', $excursion->category_excursion_id) == $category->id ? 'selected' : '' }}>
                                                    {{ data_get($category->name, app()->getLocale(), $category->name['en']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_excursion_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_ar" class="form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name[ar]" id="name_ar"
                                            value="{{ old('name.ar', data_get($category_excursion->name, 'ar', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the category excursion name') }}">
                                        @error('name.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_en" class="form-label">{{ __('Name EN') }}</label>
                                        <input type="text" name="name[en]" id="name_en"
                                            value="{{ old('name.en', data_get($category_excursion->name, 'en', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the category excursion name') }}">
                                        @error('name.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_es" class="form-label">{{ __('Name Es') }}</label>
                                        <input type="text" name="name[es]" id="name_es"
                                            value="{{ old('name.es', data_get($category_excursion->name, 'es', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the category excursion name') }}">
                                        @error('name.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_it" class="form-label">{{ __('Name It') }}</label>
                                        <input type="text" name="name[it]" id="name_it"
                                            value="{{ old('name.it', data_get($category_excursion->name, 'it', '')) }}"
                                            class="form-control"
                                            placeholder="{{ __('Enter the category excursion name') }}">
                                        @error('name.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name De</label>
                                        <input type="text" name="name[de]"
                                            value="{{ old('name.de', data_get($category_excursion->name, 'de')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ja</label>
                                        <input type="text" name="name[ja]"
                                            value="{{ old('name.ja', data_get($category_excursion->name, 'ja')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Zh</label>
                                        <input type="text" name="name[zh]"
                                            value="{{ old('name.zh', data_get($category_excursion->name, 'zh')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ru</label>
                                        <input type="text" name="name[ru]"
                                            value="{{ old('name.ru', data_get($category_excursion->name, 'ru')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Fr</label>
                                        <input type="text" name="name[fr]"
                                            value="{{ old('name.fr', data_get($category_excursion->name, 'fr')) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
                                        <select class="form-select" name="is_active" id="is_active">
                                            <option value="" disabled>{{ __('Choose is_active...') }}</option>
                                            <option value="0"
                                                {{ old('is_active', $category_excursion->is_active) == 0 ? 'selected' : '' }}>
                                                {{ __('UnActive') }}</option>
                                            <option value="1"
                                                {{ old('is_active', $category_excursion->is_active) == 1 ? 'selected' : '' }}>
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

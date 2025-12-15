@extends('dashboard.layouts.app')
@section('title', __('Add Excursion'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Add Excursion') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('Admin.excursions.index') }}">{{ __('Excursions') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Add Excursion') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="post" action="{{ route('Admin.excursions.store') }}" enctype="multipart/form-data"
                        class="p-3 rounded shadow-lg bg-white">
                        @csrf
                        <div class="card border-0">
                            <div class="card-header bg-primary text-white rounded-top">
                                <h5 class="mb-0">{{ __('Add City') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">


                                    <div class="col-md-6">
                                        <label for="name_ar" class="form-label">{{ __('Name Ar') }}</label>
                                        <input type="text" name="name[ar]" id="name_ar" value="{{ old('name.ar') }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('name.ar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_en" class="form-label">{{ __('Name En') }}</label>
                                        <input type="text" name="name[en]" id="name_en" value="{{ old('name.en') }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('name.en')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name_es" class="form-label">{{ __('Name Es') }}</label>
                                        <input type="text" name="name[es]" id="name_es" value="{{ old('name.es') }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('name.es')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="name_it" class="form-label">{{ __('Name It') }}</label>
                                        <input type="text" name="name[it]" id="name_it" value="{{ old('name.it') }}"
                                            class="form-control" placeholder="{{ __('Enter the city name') }}">
                                        @error('name.it')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name De</label>
                                        <input type="text" name="name[de]" value="{{ old('name.de') }}"
                                            class="form-control">
                                        @error('name.de')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ja</label>
                                        <input type="text" name="name[ja]" value="{{ old('name.ja') }}"
                                            class="form-control">
                                        @error('name.ja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Zh</label>
                                        <input type="text" name="name[zh]" value="{{ old('name.zh') }}"
                                            class="form-control">
                                        @error('name.zh')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Ru</label>
                                        <input type="text" name="name[ru]" value="{{ old('name.ru') }}"
                                            class="form-control">
                                        @error('name.ru')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Name Fr</label>
                                        <input type="text" name="name[fr]" value="{{ old('name.fr') }}"
                                            class="form-control">
                                        @error('name.fr')
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
                                            <option value="" {{ old('is_active') === null ? 'selected' : '' }}>
                                                {{ __('Choose is_active...') }}</option>
                                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>
                                                {{ __('UnActive') }}</option>
                                            <option value="1" {{ old('is_active') === '1' ? 'selected' : '' }}>
                                                {{ __('Active') }}</option>
                                        </select>
                                        @error('is_active')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>




                                </div>
                            </div>
                            <div class="card-footer text-end bg-light rounded-bottom">
                                <button type="submit" class="btn btn-primary px-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

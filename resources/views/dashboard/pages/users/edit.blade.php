@extends('dashboard.layouts.app')
@section('title', __('Edit User'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0 font-medium">{{ __('Edit User') }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.users.index') }}">{{ __('Users') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ __('Edit User') }}</li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row mb-5">
            <div class="col-12">
                <form method="post"
                      action="{{ route('Admin.users.update', $user->id) }}"
                      enctype="multipart/form-data"
                      class="p-3 rounded shadow-lg bg-white">

                    @csrf
                    @method('PUT')

                    <div class="card border-0">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h5 class="mb-0">{{ __('Edit User') }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name', $user->name) }}">
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Email') }}</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $user->email) }}">
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone', $user->phone) }}">
                                </div>

                                {{-- Image --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Image') }}</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                {{-- Is Active --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Is Active') }}</label>
                                    <select class="form-select" name="is_active">
                                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>
                                            {{ __('UnActive') }}
                                        </option>
                                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>
                                            {{ __('Active') }}
                                        </option>
                                    </select>
                                </div>

                                {{-- Type --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Type') }}</label>
                                    <select class="form-select" name="type" id="type">
                                        <option value="">{{ __('Choose the user type') }}</option>
                                        @foreach (\App\Enums\UserType::options() as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('type', $user->type?->value) === $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Category --}}
                                <div class="col-md-6" id="category_div" style="display:none;">
                                    <label class="form-label">{{ __('Category') }}</label>
                                    <select name="category_excursion_id"
                                            id="category_excursion_id"
                                            class="form-select">
                                        <option value="">{{ __('Choose...') }}</option>
                                        @foreach ($category_excursions as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_excursion_id', $user->category_excursion_id) == $category->id ? 'selected' : '' }}>
                                                {{ data_get($category->name, app()->getLocale(), $category->name['en']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Sub Category --}}
                                <div class="col-md-6" id="sub_category_div" style="display:none;">
                                    <label class="form-label">{{ __('Sub Category') }}</label>
                                    <select name="sub_category_excursion_id"
                                            id="sub_category_excursion_id"
                                            class="form-select">
                                        <option value="">{{ __('Choose...') }}</option>
                                    </select>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Password') }}</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end bg-light rounded-bottom">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection


{{-- ================= JS ================= --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const supplierValue = 'supplier';

    const typeSelect = document.getElementById('type');
    const categoryDiv = document.getElementById('category_div');
    const categorySelect = document.getElementById('category_excursion_id');

    const subCategoryDiv = document.getElementById('sub_category_div');
    const subCategorySelect = document.getElementById('sub_category_excursion_id');

    const selectedCategoryId = "{{ old('category_excursion_id', $user->category_excursion_id) }}";
    const selectedSubCategoryId = "{{ old('sub_category_excursion_id', $user->sub_category_excursion_id) }}";

    function toggleCategory() {
        if (typeSelect.value === supplierValue) {
            categoryDiv.style.display = 'block';

            if (selectedCategoryId) {
                loadSubCategories(selectedCategoryId, selectedSubCategoryId);
            }
        } else {
            categoryDiv.style.display = 'none';
            subCategoryDiv.style.display = 'none';
            categorySelect.value = '';
            subCategorySelect.innerHTML = '<option value="">Choose...</option>';
        }
    }

    function loadSubCategories(categoryId, selectedId = null) {
        if (!categoryId) {
            subCategoryDiv.style.display = 'none';
            return;
        }

        fetch(`/admin/sub-categories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">Choose...</option>';

                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent =
                        item.name['{{ app()->getLocale() }}'] ?? item.name['en'];

                    if (selectedId && selectedId == item.id) {
                        option.selected = true;
                    }

                    subCategorySelect.appendChild(option);
                });

                subCategoryDiv.style.display = 'block';
            });
    }

    typeSelect.addEventListener('change', toggleCategory);
    categorySelect.addEventListener('change', function () {
        loadSubCategories(this.value);
    });

    toggleCategory();
});
</script>
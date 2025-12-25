@extends('dashboard.layouts.app')
@section('title', __('Category Events'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Category Events') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Category Events') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="row mb-5">
                <div class="col-12 col-xl-12">
                    <div class="card">

                        <!-- Add User Button -->

                        <div class="card-header flex justify-between items-center">
                            <h5>{{ __('Category Events List') }}</h5>

                            @can('category_events-create')
                                <a href="{{ route('Admin.category_events.create') }}" class="btn btn-primary">
                                    <i class="fas fa-add"></i> {{ __('Add Category Event') }}
                                </a>
                            @endcan
                        </div>
                        <!-- Table -->
                        <div class="card-body">
                            <div class="table-responsive text-center">
                                <table id="example2" class="table table-striped table-bordered">

                                    <form action="{{ route('Admin.category_events.bulkDelete') }}" method="post" id="bulkDeleteForm">
                                        @csrf

                                        <thead>
                                            <tr>
                                                <th>{{ __('ID') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Active') }}</th>
                                                <th>
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($category_events as $category_event)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $category_event->name[app()->getLocale()] }}</td>
                                                    <td>{{ $category_event->is_active == 1 ? 'Active' : 'Unactive' }}</td>
                                                    <td>
                                                        <input type="checkbox" name="ids[]" value="{{ $category_event->id }}"
                                                            class="userCheckbox">
                                                    </td>

                                                    <td>
                                                        @can('category_events-delete')
                                                            <button type="button" class="btn btn-danger w-25 delete-user-btn"
                                                                data-id="{{ $category_event->id }}">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        @endcan


                                                        @can('category_events-update')
                                                            <a href="{{ route('Admin.category_events.edit', $category_event) }}"
                                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">{{ __('Nothing!') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                </table>

                                <!-- Bulk Delete Button -->
                                <button type="button" id="bulkDeleteBtn" class="btn btn-danger mt-2">
                                    <i class="far fa-trash-alt"></i> {{ __('Delete Selected') }}
                                </button>

                                </form>

                                <!-- Pagination -->
                                <div class="mt-3" style="padding:5px;direction: ltr;">
                                    {!! $category_events->withQueryString()->links('pagination::bootstrap-5') !!}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');

                    Swal.fire({
                        title: '{{ __('Are you sure?') }}',
                        text: "{{ __('Do you want to delete this item') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC143C',
                        cancelButtonColor: '#696969',
                        cancelButtonText: "{{ __('Cancel') }}",
                        confirmButtonText: '{{ __('Yes, delete it!') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.createElement('form');
                            form.action = '{{ url('/admin/category_events') }}/' + id;
                            form.method = 'POST';
                            form.style.display = 'none';

                            let csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';

                            let methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';

                            form.appendChild(csrfInput);
                            form.appendChild(methodInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const selectAll = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.userCheckbox');
            const storageKey = 'selectedUserIds';


            let selectedIds = JSON.parse(localStorage.getItem(storageKey)) || [];


            function updateStorage() {
                localStorage.setItem(storageKey, JSON.stringify(selectedIds));
            }


            function refreshCheckboxes() {
                userCheckboxes.forEach(cb => {
                    cb.checked = selectedIds.includes(parseInt(cb.value));
                });

                selectAll.checked = userCheckboxes.length === selectedIds.length && userCheckboxes.length > 0;
            }


            refreshCheckboxes();


            userCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const id = parseInt(this.value);
                    if (this.checked) {
                        if (!selectedIds.includes(id)) {
                            selectedIds.push(id);
                        }
                    } else {
                        selectedIds = selectedIds.filter(i => i !== id);
                    }
                    updateStorage();

                    selectAll.checked = userCheckboxes.length === selectedIds.length &&
                        userCheckboxes.length > 0;
                });
            });


            selectAll.addEventListener('change', function() {
                if (this.checked) {
                    userCheckboxes.forEach(cb => {
                        cb.checked = true;
                        const id = parseInt(cb.value);
                        if (!selectedIds.includes(id)) {
                            selectedIds.push(id);
                        }
                    });
                } else {
                    userCheckboxes.forEach(cb => {
                        cb.checked = false;
                        const id = parseInt(cb.value);
                        selectedIds = selectedIds.filter(i => i !== id);
                    });
                }
                updateStorage();
            });


            document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {

                const existing = this.querySelectorAll('input[name="ids[]"]');
                existing.forEach(input => input.remove());


                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    this.appendChild(input);
                });


                localStorage.removeItem(storageKey);
            });
        });



        document.getElementById('bulkDeleteBtn').addEventListener('click', function(e) {
            e.preventDefault();


            let selectedIds = JSON.parse(localStorage.getItem('selectedUserIds')) || [];

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __('No cities selected!') }}',
                    text: '{{ __('Please select at least one user to delete.') }}',
                });
                return;
            }

            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: "{{ __('Do you want to delete the selected cities?') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC143C',
                cancelButtonColor: '#696969',
                cancelButtonText: "{{ __('Cancel') }}",
                confirmButtonText: '{{ __('Yes, delete them!') }}'
            }).then((result) => {
                if (result.isConfirmed) {

                    const form = document.getElementById('bulkDeleteForm');
                    form.submit();


                    localStorage.removeItem('selectedUserIds');
                }
            });
        });
    </script>
@endpush

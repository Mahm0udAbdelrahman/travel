@extends('dashboard.layouts.app')
@section('title', __('Order Additional Service'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Order Additional Services') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Order Additional Service') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="row mb-5">
                <div class="col-12 col-xl-12">
                    <div class="card">

                        <!-- Add User Button -->

                        <div class="card-header flex justify-between items-center">
                            <h5>{{ __('Order Additional Services List') }}</h5>
                        </div>
                        <!-- Table -->
                        <div class="card-body">
                            <div class="table-responsive text-center">
                                <table id="example2" class="table table-striped table-bordered">

                                    <form action="{{ route('Admin.order_additional_services.bulkDelete') }}" method="post"
                                        id="bulkDeleteForm">
                                        @csrf

                                        <thead>
                                            <tr>
                                                <th>{{ __('ID') }}</th>
                                                <th>{{ __('User Name') }}</th>
                                                <th>{{ __('User Phone') }}</th>
                                                <th>{{ __('Additional Services') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Time') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Note') }}</th>
                                                <th>
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($order_additional_services as $order_additional_service)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $order_additional_service->user->name }}</td>
                                                    <td>{{ $order_additional_service->user->phone }}</td>
                                                    <td>{{ $order_additional_service->additionalService->name[app()->getLocale()] }}
                                                    </td>
                                                    <td>{{ $order_additional_service->date }}</td>
                                                    <td>{{ $order_additional_service->time }}</td>
                                                    <td>{{ $order_additional_service->type }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($order_additional_service->notes, 10, '...') }}
                                                    </td>


                                                    </td>

                                                    <td>
                                                        <input type="checkbox" name="ids[]"
                                                            value="{{ $order_additional_service->id }}"
                                                            class="userCheckbox">
                                                    </td>

                                                    <td>
                                                        @can('order_additional_services-delete')
                                                            <button type="button" class="btn btn-danger w-25 delete-user-btn"
                                                                data-id="{{ $order_additional_service->id }}">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        @endcan

                                                        @can('order_additional_services-show')
                                                            <a href="{{ route('Admin.order_additional_services.show', $order_additional_service->id) }}"
                                                                class="btn btn-info w-25">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
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
                                    {!! $order_additional_services->withQueryString()->links('pagination::bootstrap-5') !!}
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
                            form.action = '{{ url('/admin/additional_services') }}/' + id;
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
                    title: '{{ __('No additional_services selected!') }}',
                    text: '{{ __('Please select at least one user to delete.') }}',
                });
                return;
            }

            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: "{{ __('Do you want to delete the selected additional_services?') }}",
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

@extends('dashboard.layouts.app')
@section('title', __('Orders'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div class="page-block">
                    <div class="page-header-title">
                        <h4 class="mb-1 fw-bold">{{ __('Orders Management') }}</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-muted">{{ __('Orders') }}</li>
                    </ul>
                </div>
                {{-- اختياري: زر إضافة طلب لو احتجت مستقبلاً --}}
                {{-- <div class=""><a href="#" class="btn btn-primary btn-sm rounded-pill shadow-sm"><i class="fas fa-plus me-1"></i> New Order</a></div> --}}
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('Admin.orders.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">{{ __('From Date') }}</label>
                            <input type="date" name="from_date" class="form-control border-light-subtle"
                                value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">{{ __('To Date') }}</label>
                            <input type="date" name="to_date" class="form-control border-light-subtle"
                                value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">{{ __('Status') }}</label>
                            <select name="status" class="form-select border-light-subtle">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    {{ __('Completed') }}
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    {{ __('Cancelled') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary w-100 flex-grow-1">
                                <i class="fas fa-filter me-1"></i> {{ __('Filter') }}
                            </button>
                            <a href="{{ route('Admin.orders.index') }}" class="btn btn-light border w-100">
                                {{ __('Reset') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-shopping-cart me-2"></i>{{ __('Orders List') }}</h5>
                    <button type="button" id="bulkDeleteBtn" class="btn btn-outline-danger btn-sm d-none">
                        <i class="fas fa-trash-alt me-1"></i> {{ __('Delete Selected') }}
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <form action="{{ route('Admin.orders.bulkDelete') }}" method="post" id="bulkDeleteForm">
                            @csrf
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th>{{ __('Order No') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Date & Time') }}</th>
                                        <th>{{ __('Details') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th class="text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input orderCheckbox" type="checkbox"
                                                        value="{{ $order->id }}">
                                                </div>
                                            </td>
                                            <td><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width:32px; height:32px;">
                                                        <span
                                                            class="small fw-bold">{{ substr($order->user?->name ?? '?', 0, 1) }}</span>
                                                    </div>
                                                    <span>{{ $order->user?->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="badge bg-light text-dark border">{{ class_basename($order->orderable_type) }}</span>
                                            </td>
                                            <td class="small text-muted">
                                                <div><i class="far fa-calendar-alt me-1"></i>{{ $order->date }}</div>
                                                <div><i class="far fa-clock me-1"></i>{{ $order->time }}</div>
                                            </td>
                                            <td><span
                                                    class="badge bg-secondary-subtle text-secondary">{{ $order->quantity }}
                                                    Units</span></td>
                                            <td class="fw-bold text-primary">{{ number_format($order->price, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'completed' => 'bg-success',
                                                        'pending' => 'bg-warning text-dark',
                                                        'cancelled' => 'bg-danger',
                                                    ];
                                                    $class =
                                                        $statusClasses[strtolower($order->status)] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge rounded-pill {{ $class }} px-3">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-center">
                                                    @can('orders-show')
                                                        <a href="{{ route('Admin.orders.show', $order) }}"
                                                            class="btn btn-sm btn-icon btn-light-primary" title="View">
                                                            <i class="fas fa-eye text-primary"></i>
                                                        </a>
                                                    @endcan
                                                    @can('orders-update')
                                                        <a href="{{ route('Admin.orders.edit', $order) }}"
                                                            class="btn btn-sm btn-icon btn-light-info" title="Edit">
                                                            <i class="fas fa-edit text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @can('orders-delete')
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-light-danger delete-btn"
                                                            data-id="{{ $order->id }}" title="Delete">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-5 text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block op-3"></i>
                                                {{ __('No Orders Found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center" style="direction:ltr">
                        {!! $orders->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* لمسات جمالية سريعة */
        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-light-primary {
            background: #e7f1ff;
            border: none;
        }

        .btn-light-info {
            background: #e7faff;
            border: none;
        }

        .btn-light-danger {
            background: #ffe7e7;
            border: none;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
        }

        .table thead th {
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f8f9fa;
        }

        .avatar-sm {
            color: #007bff;
            border: 1px solid #dee2e6;
        }
    </style>
@endsection
@push('scripts')
    <script>
        const storageKey = 'selectedOrderIds';
        const bulkBtn = document.getElementById('bulkDeleteBtn');
        const selectAll = document.getElementById('selectAll');
        const boxes = document.querySelectorAll('.orderCheckbox');

        let selected = JSON.parse(localStorage.getItem(storageKey)) || [];

        function updateBulkButtonVisibility() {
            if (selected.length > 0) {
                bulkBtn.classList.remove('d-none');
                bulkBtn.innerHTML = `<i class="fas fa-trash-alt me-1"></i> Delete (${selected.length})`;
            } else {
                bulkBtn.classList.add('d-none');
            }
        }

        function sync() {
            boxes.forEach(cb => {
                cb.checked = selected.includes(parseInt(cb.value));
            });
            updateBulkButtonVisibility();
        }

        sync();

        boxes.forEach(cb => {
            cb.onchange = () => {
                let id = parseInt(cb.value);
                if (cb.checked) {
                    selected.push(id);
                } else {
                    selected = selected.filter(x => x !== id);
                }
                localStorage.setItem(storageKey, JSON.stringify([...new Set(selected)]));
                updateBulkButtonVisibility();
            }
        });

        selectAll.onchange = () => {
            boxes.forEach(cb => {
                cb.checked = selectAll.checked;
                let id = parseInt(cb.value);
                if (selectAll.checked) {
                    selected.push(id);
                } else {
                    selected = selected.filter(x => x !== id);
                }
            });
            selected = [...new Set(selected)];
            localStorage.setItem(storageKey, JSON.stringify(selected));
            updateBulkButtonVisibility();
        };

        // كود الحذف الفردي (بقيت كما هي مع تحسين المسار)
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = function() {
                let id = this.dataset.id;
                Swal.fire({
                    title: '{{ __('Are you sure?') }}',
                    text: '{{ __('This action cannot be undone!') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('Yes, delete it!') }}'
                }).then(r => {
                    if (r.isConfirmed) {
                        let f = document.createElement('form');
                        f.method = 'POST';
                        f.action = '/admin/orders/' + id;
                        f.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(f);
                        f.submit();
                    }
                });
            }
        });

        bulkBtn.onclick = () => {
            Swal.fire({
                title: '{{ __('Delete Multiple?') }}',
                text: `{{ __('You are about to delete') }} ${selected.length} {{ __('orders') }}`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33'
            }).then(r => {
                if (r.isConfirmed) {
                    // إضافة الـ IDs المختارة للفورم قبل الإرسال
                    const form = document.getElementById('bulkDeleteForm');
                    selected.forEach(id => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });
                    form.submit();
                    localStorage.removeItem(storageKey);
                }
            });
        };
    </script>
@endpush

@extends('dashboard.layouts.app')
@section('title', __('Orders Management'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div class="page-block">
                    <div class="page-header-title">
                        <h4 class="mb-1 fw-bold">{{ __('Orders Management') }}</h4>
                    </div>
                    <ul class="breadcrumb text-sm">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-muted">{{ __('Advanced Orders Filter') }}</li>
                    </ul>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="mb-0"><i class="fas fa-filter me-2 text-primary"></i>{{ __('Filter Orders') }}</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('Admin.orders.index') }}" class="row g-3 align-items-end">
                        {{--  <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('From Date') }}</label>
                            <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                        </div>  --}}
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('To Date') }}</label>
                            <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('Hotel') }}</label>
                            <select name="hotel_id" class="form-select form-select-sm">
                                <option value="">{{ __('All Hotels') }}</option>
                                @foreach(\App\Models\Hotel::all() as $hotel)
                                    <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                        {{ is_array($hotel->name) ? ($hotel->name[app()->getLocale()] ?? $hotel->name['en']) : $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('Order Type') }}</label>
                            <select name="orderable_type" id="orderTypeSelect" class="form-select form-select-sm">
                                <option value="">{{ __('All Types') }}</option>
                                <option value="App\Models\Excursion" {{ request('orderable_type') == 'App\Models\Excursion' ? 'selected' : '' }}>{{ __('Excursion') }}</option>
                                <option value="App\Models\RealEstate" {{ request('orderable_type') == 'App\Models\RealEstate' ? 'selected' : '' }}>{{ __('Real Estate') }}</option>
                                <option value="App\Models\Event" {{ request('orderable_type') == 'App\Models\Event' ? 'selected' : '' }}>{{ __('Event') }}</option>
                                <option value="App\Models\Offer" {{ request('orderable_type') == 'App\Models\Offer' ? 'selected' : '' }}>{{ __('Offer') }}</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('Status') }}</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                        </div>

                        <div class="col-md-3 excursion-extra-fields {{ request('orderable_type') == 'App\Models\Excursion' ? '' : 'd-none' }}">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('Excursion Category') }}</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach(\App\Models\CategoryExcursion::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ is_array($cat->name) ? ($cat->name[app()->getLocale()] ?? $cat->name['en']) : $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 excursion-extra-fields {{ request('orderable_type') == 'App\Models\Excursion' ? '' : 'd-none' }}">
                            <label class="form-label small fw-bold text-muted uppercase">{{ __('Sub Category') }}</label>
                            <select name="subcategory_id" class="form-select form-select-sm">
                                <option value="">{{ __('All Sub-Cats') }}</option>
                                @foreach(\App\Models\SubCategoryExcursion::all() as $sub)
                                    <option value="{{ $sub->id }}" {{ request('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                        {{ is_array($sub->name) ? ($sub->name[app()->getLocale()] ?? $sub->name['en']) : $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-filter"></i></button>
                            <a href="{{ route('Admin.orders.index') }}" class="btn btn-light btn-sm border flex-grow-1"><i class="fas fa-undo"></i></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-list me-2"></i>{{ __('Orders Results') }}</h5>
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
                                        <th class="ps-4" style="width: 40px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th>{{ __('Order No') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Hotel') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Date & Time') }}</th>
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
                                                    <input class="form-check-input orderCheckbox" type="checkbox" value="{{ $order->id }}">
                                                </div>
                                            </td>
                                            <td><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                                            <td>
                                                <div class="small font-bold text-dark">{{ $order->user?->name ?? 'Guest' }}</div>
                                                <div class="text-muted" style="font-size: 10px;">{{ $order->user?->phone }}</div>
                                            </td>
                                            <td>
                                                <span class="text-muted small">
                                                    {{ is_array($order->hotel?->name) ? ($order->hotel->name[app()->getLocale()] ?? 'N/A') : ($order->hotel?->name ?? '-') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border-1 border">
                                                    {{ class_basename($order->orderable_type) }}
                                                </span>
                                            </td>
                                            <td class="small">
                                                <div class="text-dark">{{ $order->date }}</div>
                                                <div class="text-muted" style="font-size: 11px;">{{ $order->time }}</div>
                                            </td>
                                            <td class="fw-bold text-primary">{{ number_format($order->price, 2) }}</td>
                                            <td>
                                                @php
                                                    $color = match($order->status) {
                                                        'completed' => 'bg-success',
                                                        'pending' => 'bg-warning text-dark',
                                                        'cancelled' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge rounded-pill {{ $color }} px-3">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-center">
                                                    @can('orders-show')
                                                    <a href="{{ route('Admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-light-warning"><i class="fas fa-eye"></i></a>
                                                    @endcan
                                                    @can('orders-update')
                                                     <a href="{{ route('Admin.orders.edit', $order) }}" class="btn btn-sm btn-icon btn-light-primary"><i class="fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('orders-delete')
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-btn" data-id="{{ $order->id }}"><i class="far fa-trash-alt"></i></button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-5 text-center text-muted">
                                                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                                <p>{{ __('No orders match your criteria') }}</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        {!! $orders->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
            </div>
    </div>

    <style>
        .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: 0.3s; border: none; }
        .btn-light-primary { background: #e7f1ff; color: #0d6efd; }
        .btn-light-danger { background: #ffe7e7; color: #dc3545; }
        .btn-icon:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .table thead th { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #6c757d; }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. التبديل اللحظي لحقول الرحلات
            const typeSelect = document.getElementById('orderTypeSelect');
            const excursionFields = document.querySelectorAll('.excursion-extra-fields');

            typeSelect.addEventListener('change', function () {
                if (this.value === 'App\\Models\\Excursion') {
                    excursionFields.forEach(f => f.classList.remove('d-none'));
                } else {
                    excursionFields.forEach(f => {
                        f.classList.add('d-none');
                        f.querySelector('select').value = ""; // تصفير القيم عند الإخفاء
                    });
                }
            });

            // 2. إدارة الحذف الجماعي (Bulk Delete)
            const bulkBtn = document.getElementById('bulkDeleteBtn');
            const selectAll = document.getElementById('selectAll');
            const boxes = document.querySelectorAll('.orderCheckbox');
            let selected = [];

            function updateBulkUI() {
                bulkBtn.classList.toggle('d-none', selected.length === 0);
                bulkBtn.innerHTML = `<i class="fas fa-trash-alt me-1"></i> Delete (${selected.length})`;
            }

            boxes.forEach(cb => {
                cb.onchange = () => {
                    const id = parseInt(cb.value);
                    if (cb.checked) selected.push(id);
                    else selected = selected.filter(x => x !== id);
                    updateBulkUI();
                }
            });

            selectAll.onchange = () => {
                selected = [];
                boxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    if (selectAll.checked) selected.push(parseInt(cb.value));
                });
                updateBulkUI();
            };

            // 3. الحذف الفردي (SweetAlert)
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
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
        });
    </script>
@endpush

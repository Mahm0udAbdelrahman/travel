@extends('dashboard.layouts.app')
@section('title', __('Orders'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Orders') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('Admin.home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ __('Orders') }}</li>
                    </ul>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header flex justify-between items-center">
                            <h5>{{ __('Orders List') }}</h5>

                            {{--  @can('orders-create')
                                <a href="{{ route('Admin.orders.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add Order') }}
                                </a>
                            @endcan  --}}
                        </div>

                        <div class="card-body">
                            <div class="table-responsive text-center">

                                <form action="{{ route('Admin.orders.bulkDelete') }}" method="post" id="bulkDeleteForm">
                                    @csrf

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Order No') }}</th>
                                                <th>{{ __('User') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                {{--  <th>{{ __('Item') }}</th>  --}}
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Qty') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order->order_number }}</td>

                                                    <td>
                                                        {{ $order->user?->name ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ class_basename($order->orderable_type) }}
                                                    </td>

                                                    {{--  <td>
                                                        {{ $order->orderable->name ?? ($order->orderable->title ?? '#' . $order->orderable_id) }}
                                                    </td>  --}}

                                                    <td>{{ $order->date }} {{ $order->time }}</td>

                                                    <td>{{ $order->quantity }}</td>

                                                    <td>{{ $order->price }}</td>

                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <input type="checkbox" class="orderCheckbox"
                                                            value="{{ $order->id }}">
                                                    </td>

                                                    <td class="d-flex gap-1 justify-content-center">

                                                        @can('orders-delete')
                                                            <button type="button" class="btn btn-danger delete-btn"
                                                                data-id="{{ $order->id }}">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        @endcan

                                                        @can('orders-show')
                                                            <a href="{{ route('Admin.orders.show', $order) }}"
                                                                class="btn btn-warning">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endcan

                                                        @can('orders-update')
                                                            <a href="{{ route('Admin.orders.edit', $order) }}"
                                                                class="btn btn-info">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11">{{ __('No Orders Found') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger mt-2">
                                        {{ __('Delete Selected') }}
                                    </button>

                                </form>

                                <!-- Pagination -->
                                <div class="mt-3" style="direction:ltr">
                                    {!! $orders->links('pagination::bootstrap-5') !!}
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
        const storageKey = 'selectedOrderIds';

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = function() {
                let id = this.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (r.isConfirmed) {
                        let f = document.createElement('form');
                        f.method = 'POST';
                        f.action = '/admin/orders/' + id;

                        f.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                        document.body.appendChild(f);
                        f.submit();
                    }
                });
            }
        });

        const selectAll = document.getElementById('selectAll');
        const boxes = document.querySelectorAll('.orderCheckbox');
        let selected = JSON.parse(localStorage.getItem(storageKey)) || [];

        function sync() {
            boxes.forEach(cb => cb.checked = selected.includes(+cb.value));
        }
        sync();

        boxes.forEach(cb => {
            cb.onchange = () => {
                let id = +cb.value;
                selected = cb.checked ?
                    [...new Set([...selected, id])] :
                    selected.filter(x => x !== id);

                localStorage.setItem(storageKey, JSON.stringify(selected));
            }
        });

        selectAll.onchange = () => {
            boxes.forEach(cb => {
                cb.checked = selectAll.checked;
                if (selectAll.checked) selected.push(+cb.value);
            });
            selected = [...new Set(selected)];
            localStorage.setItem(storageKey, JSON.stringify(selected));
        };

        document.getElementById('bulkDeleteBtn').onclick = () => {
            if (!selected.length) {
                Swal.fire('Select orders first');
                return;
            }
            document.getElementById('bulkDeleteForm').submit();
            localStorage.removeItem(storageKey);
        };
    </script>
@endpush

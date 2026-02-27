@extends('dashboard.layouts.app')
@section('title', __('Reports'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            {{-- Page Header --}}
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h4 class="mb-0 text-primary"><i
                                        class="fas fa-chart-line me-2"></i>{{ __('Advanced Reports') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards (اختياري لكنه يعطي شكل فخم) --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <h6>Total Orders</h6>
                            <h3>{{ $orders->total() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body">
                            <h6>Total Revenue</h6>
                            <h3>{{ number_format($orders->sum('price'), 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters Section --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <h5 class="mb-0"><i class="fas fa-filter text-muted me-2"></i>{{ __('Filters') }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('Admin.reports') }}" class="row g-4">

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Hotel</label>
                            <select name="hotel_id" class="form-select border-light-subtle shadow-none">
                                <option value="">All Hotels</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" @selected(request('hotel_id') == $hotel->id)>
                                        {{ $hotel->name['en'] ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Supplier</label>
                            <select name="supplier_id" class="form-control select2">
                                <option value="">All Suppliers</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Representative</label>
                            <select name="representative_id" class="form-control select2">
                                <option value="">All Representatives</option>
                                @foreach ($representatives as $rep)
                                    <option value="{{ $rep->id }}" @selected(request('representative_id') == $rep->id)>
                                        {{ $rep->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Service Type</label>
                            <select name="orderable_type" id="orderable_type" class="form-select border-light-subtle">
                                <option value="">All Types</option>
                                <option value="excursion" @selected(request('orderable_type') == 'excursion')>Excursion</option>
                                <option value="real_estate" @selected(request('orderable_type') == 'real_estate')>Real Estate</option>
                                <option value="event" @selected(request('orderable_type') == 'event')>Event</option>
                                <option value="additional_service" @selected(request('orderable_type') == 'additional_service')>Additional Service</option>
                            </select>
                        </div>

                        {{-- Excursion Filters (Animated appearance) --}}
                        <div class="col-md-3" id="excursion_category_wrapper" style="display:none;">
                            <label class="form-label fw-bold text-primary">Category</label>
                            <select name="category_id" class="form-select border-primary-subtle">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                        {{ $category->name['en'] ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3" id="excursion_subcategory_wrapper" style="display:none;">
                            <label class="form-label fw-bold text-primary">Sub Category</label>
                            <select name="sub_category_id" class="form-select border-primary-subtle">
                                <option value="">All Sub-Categories</option>
                                @foreach ($subCategories as $sub)
                                    <option value="{{ $sub->id }}" @selected(request('sub_category_id') == $sub->id)>
                                        {{ $sub->name['en'] ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">From Date</label>
                            <input type="date" name="from" class="form-control border-light-subtle"
                                value="{{ request('from') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">To Date</label>
                            <input type="date" name="to" class="form-control border-light-subtle"
                                value="{{ request('to') }}">
                        </div>

                        <div class="col-md-12 text-end mt-4">
                            <a href="{{ route('Admin.reports') }}" class="btn btn-light-secondary me-2">Reset</a>
                            <button type="submit" name="export" value="1" class="btn btn-success me-2">
                                <i class="fas fa-file-excel me-2"></i> Export to Excel
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-search me-2"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Order No</th>
                                    <th>User Info</th>
                                    <th>Hotel</th>
                                    <th>Service</th>
                                    <th>Booking Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold">#{{ $order->order_number }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-1">
                                                    <h6 class="mb-0">{{ $order->user?->name }}</h6>
                                                    <small
                                                        class="badge bg-light-info text-info">{{ $order->user?->type?->label() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted">{{ $order->hotel?->name['en'] ?? '-' }}</span></td>
                                        <td>
                                            @php
                                                $typeLabels = [
                                                    \App\Models\Excursion::class => [
                                                        'label' => 'Excursion',
                                                        'class' => 'bg-light-primary text-primary',
                                                    ],
                                                    \App\Models\RealEstate::class => [
                                                        'label' => 'Real Estate',
                                                        'class' => 'bg-light-warning text-warning',
                                                    ],
                                                    \App\Models\Event::class => [
                                                        'label' => 'Event',
                                                        'class' => 'bg-light-danger text-danger',
                                                    ],
                                                    \App\Models\AdditionalService::class => [
                                                        'label' => 'Service',
                                                        'class' => 'bg-light-secondary text-secondary',
                                                    ],
                                                ];
                                                $config = $typeLabels[$order->orderable_type] ?? [
                                                    'label' => 'Other',
                                                    'class' => 'bg-light-dark text-dark',
                                                ];
                                            @endphp
                                            <span class="badge {{ $config['class'] }} mb-1">{{ $config['label'] }}</span>
                                            <div class="small fw-bold">{{ $order->orderable?->name['en'] ?? '-' }}</div>
                                        </td>
                                        <td><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $order->date }}</td>
                                        <td><span class="fw-bold text-dark">${{ number_format($order->price, 2) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">
                                                {{ $order->lastStatus?->status ?? '-' }}
                                            </span>
                                        </td>
                                        {{--  <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light-primary border-0"><i class="fas fa-eye"></i></button>
                                    </td>  --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png"
                                                style="width: 100px;" class="mb-3 opacity-25">
                                            <p class="text-muted">No orders found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('orderable_type');
            const category = document.getElementById('excursion_category_wrapper');
            const subCategory = document.getElementById('excursion_subcategory_wrapper');

            function toggleExcursionFilters() {
                if (typeSelect.value === 'excursion') {
                    $(category).fadeIn();
                    $(subCategory).fadeIn();
                } else {
                    category.style.display = 'none';
                    subCategory.style.display = 'none';
                }
            }

            toggleExcursionFilters();
            typeSelect.addEventListener('change', toggleExcursionFilters);

            $('.select2').select2({
                placeholder: 'Search...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <style>
        /* تحسينات بسيطة للـ CSS */
        .card {
            border-radius: 12px;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .table thead th {
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #6c757d;
        }

        .bg-light-info {
            background-color: #e0f7fa !important;
        }

        .bg-light-primary {
            background-color: #e3f2fd !important;
        }

        .badge {
            padding: 0.5em 0.8em;
        }
    </style>
@endpush

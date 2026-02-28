@extends('dashboard.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-bold text-xl">Overview Dashboard</h5>
                    </div>
                    <ul class="breadcrumb flex items-center gap-2 text-sm text-muted">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><i class="feather icon-chevron-right text-xs"></i> Dashboard</li>
                        <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-x-6">
            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card overflow-hidden border-0 shadow-sm transition-all hover:shadow-md">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-muted mb-1 font-medium">Total Orders</p>
                                <h3 class="mb-0 font-bold text-2xl text-primary-500">{{ \App\Models\Order::count() }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center text-primary-600">
                                <i class="feather icon-shopping-bag text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs">
                            <span class="text-success-500 font-bold bg-success-50 px-2 py-1 rounded-lg mr-2">+12.5%</span>
                            <span class="text-muted">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card overflow-hidden border-0 shadow-sm transition-all hover:shadow-md">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-muted mb-1 font-medium">Active Users</p>
                                <h3 class="mb-0 font-bold text-2xl text-success-500">{{ \App\Models\User::active()->count() }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-success-100 flex items-center justify-center text-success-600">
                                <i class="feather icon-users text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-muted">
                            Total Registered: {{ \App\Models\User::count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card overflow-hidden border-0 shadow-sm transition-all hover:shadow-md">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-muted mb-1 font-medium">Excursions</p>
                                <h3 class="mb-0 font-bold text-2xl text-warning-500">{{ \App\Models\Excursion::count() }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-warning-100 flex items-center justify-center text-warning-600">
                                <i class="feather icon-map text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-muted text-truncate">
                            In {{ \App\Models\City::count() }} different cities
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card overflow-hidden border-0 shadow-sm transition-all hover:shadow-md">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-muted mb-1 font-medium">Real Estate</p>
                                <h3 class="mb-0 font-bold text-2xl text-info-500">{{ \App\Models\RealEstate::count() }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-info-100 flex items-center justify-center text-info-600">
                                <i class="feather icon-home text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-muted">
                            {{ \App\Models\CategoryRealEstate::count() }} Categories
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-x-6 mt-6">
            <div class="col-span-12 xl:col-span-8">
                <div class="card border-0 shadow-sm h-full">
                    <div class="card-header flex items-center justify-between bg-transparent border-b-0 pt-6 px-6">
                        <h5 class="font-bold text-lg">Orders Performance</h5>
                        <div class="dropdown">
                            <button class="btn btn-link-secondary p-0 feather icon-more-horizontal text-xl" type="button" data-pc-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Download Report</a>
                                <a class="dropdown-item" href="#">View All Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="orders-line-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-4">
                <div class="card border-0 shadow-sm h-full">
                    <div class="card-header bg-transparent border-b-0 pt-6 px-6">
                        <h5 class="font-bold text-lg">User Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div id="user-donut-chart"></div>
                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-primary-500"></span>
                                    <span class="text-muted font-medium">Customers</span>
                                </div>
                                <span class="font-bold">{{ \App\Models\User::where('type', 'customer')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-success-500"></span>
                                    <span class="text-muted font-medium">Suppliers</span>
                                </div>
                                <span class="font-bold">{{ \App\Models\User::where('type', 'supplier')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-warning-500"></span>
                                    <span class="text-muted font-medium">Representatives</span>
                                </div>
                                <span class="font-bold">{{ \App\Models\User::where('type', 'representative')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-x-6 mt-6">
            <div class="col-span-12 xl:col-span-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header flex items-center justify-between px-6 py-5">
                        <h5 class="font-bold text-lg">Recent Orders</h5>
                        <a href="#" class="text-primary-500 text-sm font-bold hover:underline">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light-50">
                                    <tr>
                                        <th class="border-0 px-6">Order ID</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0">Type</th>
                                        <th class="border-0">Price</th>
                                        <th class="border-0 px-6">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Order::with('user')->latest()->take(6)->get() as $order)
                                    <tr>
                                        <td class="px-6 font-medium">#{{ $order->order_number }}</td>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td><span class="text-xs uppercase font-bold text-muted">{{ $order->orderable_type == 'App\Models\Excursion' ? 'Excursion' : 'Property' }}</span></td>
                                        <td class="font-bold text-dark-500">${{ number_format($order->price, 2) }}</td>
                                        <td class="px-6">
                                            @php
                                                $statusColor = match($order->status) {
                                                    'completed' => 'success',
                                                    'pending' => 'warning',
                                                    'cancelled' => 'danger',
                                                    default => 'primary'
                                                };
                                            @endphp
                                            <span class="badge bg-light-{{ $statusColor }} text-{{ $statusColor }}-500 px-3 py-1 rounded-full text-xs">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-5">
                <div class="card border-0 shadow-sm h-full">
                    <div class="card-header px-6 py-5 border-b border-light-200">
                        <h5 class="font-bold text-lg">Top Partner Hotels</h5>
                    </div>
                    <div class="card-body p-6">
                        <div class="space-y-6">
                            @foreach(\App\Models\Hotel::active()->withCount('orders')->orderBy('orders_count', 'desc')->take(5)->get() as $hotel)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-light-100 flex items-center justify-center font-bold text-primary-500">
                                        {{ substr(is_array($hotel->name) ? ($hotel->name['en'] ?? 'H') : $hotel->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-bold text-sm">{{ is_array($hotel->name) ? ($hotel->name['en'] ?? 'N/A') : $hotel->name }}</h6>
                                        <small class="text-muted">{{ $hotel->orders_count }} total orders</small>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-success-500"><i class="feather icon-arrow-up mr-1"></i>Active</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="btn btn-outline-primary w-full mt-8 rounded-xl">Manage All Hotels</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- User Distribution Donut Chart ---
        const userTypesOptions = {
            series: [
                {{ \App\Models\User::where('type', 'customer')->count() }},
                {{ \App\Models\User::where('type', 'supplier')->count() }},
                {{ \App\Models\User::where('type', 'representative')->count() }}
            ],
            chart: {
                type: 'donut',
                height: 280,
            },
            labels: ['Customers', 'Suppliers', 'Reps'],
            colors: ['#4680ff', '#2ca87f', '#e58a00'],
            dataLabels: { enabled: false },
            legend: { show: false },
            stroke: { width: 0 },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Users',
                                formatter: () => {{ \App\Models\User::count() }}
                            }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#user-donut-chart"), userTypesOptions).render();

        // --- Orders Line Chart ---
        const ordersOptions = {
            series: [{
                name: 'Orders',
                data: [31, 40, 28, 51, 42, 109, 100] // يمكنك استبدالها ببيانات حقيقية من الـ Controller
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            colors: ['#4680ff'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { show: false },
            grid: { borderColor: '#f1f1f1', strokeDashArray: 4 }
        };
        new ApexCharts(document.querySelector("#orders-line-chart"), ordersOptions).render();
    });
</script>
@endpush

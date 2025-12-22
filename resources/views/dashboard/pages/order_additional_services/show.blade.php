@extends('dashboard.layouts.app')
@section('title', __('Order Additional Service Details'))

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ __('Order Additional Service Details') }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.order_additional_services.index') }}">{{ __('Order Additional Service') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Details') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="row mb-5">
                <div class="col-12 col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Order Additional Service Details') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-start">
                                <tbody>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <td>{{ $order_additional_service->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('User Name') }}</th>
                                        <td>{{ $order_additional_service->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('User Phone') }}</th>
                                        <td>{{ $order_additional_service->user->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Additional Service') }}</th>
                                        <td>{{ $order_additional_service->additionalService->name[app()->getLocale()] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <td>{{ $order_additional_service->date ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Time') }}</th>
                                        <td>{{ $order_additional_service->time ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Type') }}</th>
                                        <td>{{ $order_additional_service->type ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Note') }}</th>
                                        <td>{{ $order_additional_service->notes ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('Admin.order_additional_services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to list') }}
                            </a>
                            @can('order_additional_services-edit')
                                <a href="{{ route('Admin.order_additional_services.edit', $order_additional_service->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

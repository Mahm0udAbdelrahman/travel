@extends('dashboard.layouts.app')
@section('title', 'Order Details')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            {{-- Page Header --}}
            <div class="page-header mb-4">
                <div class="page-block d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order #{{ $order->id }}</h4>

                    <div>
                        <a href="{{ route('Admin.orders.edit', $order->id) }}" class="btn btn-primary">
                            Edit
                        </a>

                        <a href="{{ route('Admin.orders.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- Order Main Info --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Order Information</h5>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $order->id }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>

                                 <tr>
                                    <th>Quantity</th>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                 <tr>
                                    <th>Price</th>
                                    <td>{{ $order->price }}</td>
                                </tr>

                                  <tr>
                                    <th>Total Price</th>
                                    <td>{{ number_format($order->price * $order->quantity, 2) }}</td>
                                </tr>

                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $order->created_at }}</td>
                                </tr>

                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $order->updated_at }}</td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div>

                {{-- User Info --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>User Information</h5>
                        </div>

                        <div class="card-body">

                            @if ($order->user)
                                <table class="table table-bordered">
                                    <tr>
                                        <th>User ID</th>
                                        <td>{{ $order->user->id }}</td>
                                    </tr>

                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $order->user->phone ?? '-' }}</td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted">No user attached</p>
                            @endif

                        </div>
                    </div>
                </div>
                  {{-- Orderable Details --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Related Item Details</h5>
                </div>

                <div class="card-body">

                    @if ($order->orderable)

                        @php
                            $item = $order->orderable;

                        @endphp

                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>Type</th>
                                <td>{{ class_basename($order->orderable_type) }}</td>
                            </tr>

                            <tr>
                                <th>ID</th>
                                <td>{{ $item->id }}</td>
                            </tr>

                            {{-- Name --}}
                            @if (isset($item->name))
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $item->name[app()->getLocale()] }}</td>
                                </tr>
                            @endif


                            {{-- Price --}}
                            @if (isset($item->price))
                                <tr>
                                    <th>Price</th>
                                    <td>{{ $item->price }}</td>
                                </tr>
                            @endif

                            {{-- Description --}}
                            @if (isset($item->description))
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $item->description[app()->getLocale()] }}</td>
                                </tr>
                            @endif

                            {{-- Image --}}
                            @if (isset($item->image))
                                <tr>
                                    <th>Image</th>
                                    <td>
                                        <img src="{{ asset($item->image) }}" width="120">
                                    </td>
                                </tr>
                            @endif

                            {{-- Created --}}
                            <tr>
                                <th>Created At</th>
                                <td>{{ $item->created_at ?? '-' }}</td>
                            </tr>

                            {{-- Status History --}}
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Order Status History</h5>
                                </div>

                                <div class="card-body">
                                    @if ($order->statuses->count())
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Phone</th>
                                                    <th>Status</th>
                                                    <th>Changed By</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->statuses as $status)
                                                    <tr>
                                                        <td>{{ $status->id }}</td>
                                                        <td>{{ $status->user->name }}</td>
                                                        <td>{{ $status->user->phone }}</td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $status->status }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $status->user->name ?? '-' }}</td>
                                                        <td>{{ $status->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-muted">No status history yet</p>
                                    @endif

                                </div>
                            </div>


                        </table>
                    @else
                        <p class="text-danger">No related item found</p>
                    @endif

                </div>
            </div>

            </div>



        </div>
    </div>
@endsection

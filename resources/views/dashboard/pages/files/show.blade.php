@extends('dashboard.layouts.app')
@section('title', __('Show File'))

@section('content')
<div class="pc-container">
    <div class="pc-content">

    <!-- Page Header -->
    <div class="mb-4 border-bottom pb-3">
        <h3 class="fw-bold text-primary text-uppercase">{{ $file->name[app()->getLocale()] ?? $file->name['en'] }}</h3>
        <span class="badge rounded-pill
            {{ $file->is_active ? 'bg-success' : 'bg-danger' }} py-2 px-3 fs-6 fw-semibold text-uppercase shadow-sm">
            {{ $file->is_active ? __('Active') : __('UnActive') }}
        </span>
    </div>

    {{-- Tour Leaders --}}
    <section>
        <h5 class="mb-3">{{ __('Tour Leaders') }}</h5>

        @if($file->tourLeaders->isEmpty())
            <p class="fst-italic text-secondary">{{ __('No tour leaders selected.') }}</p>
        @else
            <div class="row g-4">
                @foreach ($file->tourLeaders as $tourLeader)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0 rounded-3
                            bg-white hover-shadow cursor-pointer">
                            <div class="card-body">
                                <h6 class="card-title text-primary fw-bold mb-2"><a href="{{ route('Admin.users.show', $tourLeader->id) }}" class="text-decoration-none">{{ $tourLeader->name }}</a></h6>
                                <p class="card-text text-muted fst-italic mb-0">{{ $tourLeader->type->label() ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <a href="{{ route('Admin.files.index') }}" class="btn btn-outline-primary mt-4 rounded-pill px-4 fw-semibold">
        <i class="ti ti-arrow-left me-2"></i> {{ __('Back to Files') }}
    </a>
</div>
</div>


@push('styles')
<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.3) !important;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }
</style>
@endpush

@endsection

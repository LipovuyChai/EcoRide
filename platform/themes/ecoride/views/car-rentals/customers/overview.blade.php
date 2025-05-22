@php
    Theme::set('breadcrumb_simple', true);
    $customer = auth('customer')->user();
@endphp


@extends(CarRentalsHelper::viewPath('customers.layouts.master'))

@section('content')
    <div class="row g-4">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="text-muted small">{{ __('Name') }}</label>
                <div class="fw-medium">{{ $customer->name }}</div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">{{ __('Email') }}</label>
                <div class="fw-medium">{{ $customer->email }}</div>
            </div>

            @if ($phone = $customer->phone)
                <div class="mb-3">
                    <label class="text-muted small">{{ __('Phone') }}</label>
                    <div class="fw-medium" dir="ltr">{{ $phone }}</div>
                </div>
            @endif

        </div>
    </div>
@endsection

@extends(CarRentalsHelper::viewPath('customers.layouts.master'))

@section('content')
    <div class="row g-4">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="text-muted small">{{ __('Name') }}</label>
                <div class="fw-medium">{{ auth()->user()->name }}</div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">{{ __('Email') }}</label>
                <div class="fw-medium">{{ auth()->user()->email }}</div>
            </div>

            <div class="mb-3">
                <label class="text-muted small">{{ __('Phone') }}</label>
                <div class="fw-medium">{{ auth()->user()->phone }}</div>
            </div>
        </div>
    </div>
@endsection

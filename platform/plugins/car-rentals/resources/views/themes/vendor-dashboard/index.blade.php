@extends(CarRentalsHelper::viewPath('vendor-dashboard.layouts.master'))

@section('content')
    <x-core::stat-widget class="mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
        <x-core::stat-widget.item
            :label="__('Cars')"
            :value="$totalCars"
            icon="ti ti-car"
            color="primary"
        />

        <x-core::stat-widget.item
            :label="__('Bookings')"
            :value="$totalBookings"
            icon="ti ti-calendar-event"
            color="success"
        />

        <x-core::stat-widget.item
            :label="__('Messages')"
            :value="$totalMessages"
            icon="ti ti-mail-check"
            color="danger"
        />
    </x-core::stat-widget>
@stop

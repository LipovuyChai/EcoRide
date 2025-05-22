@extends(CarRentalsHelper::viewPath('customers.layouts.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="section-content">
                <div class="table-responsive mb-20">
                    <table class="table table-bordered custom-booking-table">
                        <thead class="text-center">
                            <tr>
                                <th>{{ __('Car') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Booking Period') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @if (count($bookings) > 0)
                                @foreach ($bookings as $booking)
                                    <tr class="align-middle">
                                        @if ($booking->car->car->exists && ($car = $booking->car->car))
                                            <td>
                                                <a
                                                    class="booking-information-link"
                                                    href="{{ $car->url }}"
                                                    target="_blank"
                                                >
                                                    {{ $car->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ $car->url }}"
                                                    target="_blank"
                                                >
                                                    <img
                                                        src="{{ RvMedia::getImageUrl($car->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                                        alt="{{ $booking->car->name }}"
                                                        width="100"
                                                    >
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                {{ $booking->car->name }}
                                            </td>
                                            <td>
                                                <img
                                                    src="{{ RvMedia::getImageUrl($booking->car->car_image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                                    alt="{{ $booking->car->name }}"
                                                    width="100"
                                                >
                                            </td>
                                        @endif
                                        <td>{{ format_price($booking->car->price) }}</td>
                                        <td>{{ $booking->car->booking_period }}</td>
                                        <td>{{ $booking->status->label() }}</td>
                                        <td>
                                            <a
                                                class="btn btn-primary btn-sm"
                                                href="{{ route('customer.bookings.show', $booking->transaction_id) }}"
                                            >{{ __('View') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td
                                        class="text-center"
                                        colspan="5"
                                    >{{ __('No bookings!') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {!! $bookings->links(CarRentalsHelper::viewPath('partials.pagination')) !!}
            </div>
        </div>
    </div>
@stop

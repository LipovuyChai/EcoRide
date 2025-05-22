@if (CarRentalsHelper::isRentalBookingEnabled())
    <div class="booking-form">
        <div class="head-booking-form">
            <p class="text-xl-bold neutral-1000">{{ __('Rent This Vehicle') }}</p>
        </div>
        <div class="content-booking-form">
            {!!
                \Botble\CarRentals\Forms\Fronts\BookingForm::createFromArray([
                    'car_id' => $car->id,
                ])
                ->modify('submit', 'submit', ['attr' => ['class' => 'btn btn-book']])
                ->renderForm()
            !!}
        </div>
    </div>
@endif

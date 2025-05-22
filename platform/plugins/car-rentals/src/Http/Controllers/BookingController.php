<?php

namespace Botble\CarRentals\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CarRentals\Events\BookingStatusChanged;
use Botble\CarRentals\Forms\BookingForm;
use Botble\CarRentals\Http\Requests\UpdateBookingRequest;
use Botble\CarRentals\Models\Booking;
use Botble\CarRentals\Tables\BookingTable;

class BookingController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/car-rentals::car-rentals.name'))
            ->add(trans('plugins/car-rentals::booking.name'), route('car-rentals.bookings.index'));
    }

    public function index(BookingTable $table)
    {
        $this->pageTitle(trans('plugins/car-rentals::booking.name'));

        return $table->renderTable();
    }

    public function edit(Booking $booking)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $booking->car->car_name]));

        return BookingForm::createFromModel($booking)->renderForm();
    }

    public function update(Booking $booking, UpdateBookingRequest $request)
    {
        $status = $booking->status;

        BookingForm::createFromModel($booking)
            ->setRequest($request)
            ->save();

        if ($booking->status != $status) {
            BookingStatusChanged::dispatch($status, $booking);
        }

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('car-rentals.bookings.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Booking $booking)
    {
        return DeleteResourceAction::make($booking);
    }
}

<?php

namespace Botble\CarRentals\Http\Controllers\Vendor;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CarRentals\Facades\CarRentalsHelper;
use Botble\CarRentals\Forms\PayoutInformationForm;
use Botble\CarRentals\Forms\Vendor\SettingForm;
use Botble\CarRentals\Http\Requests\PayoutInformationSettingRequest;
use Botble\CarRentals\Http\Requests\Vendor\SettingRequest;
use Botble\CarRentals\Models\Customer;

class SettingController extends BaseController
{
    public function index()
    {
        $this->pageTitle(__('Settings'));

        Assets::addScriptsDirectly([
            'vendor/core/plugins/location/js/location.js',
        ]);

        /**
         * @var Customer $customer
         */
        $customer = auth('customer')->user();

        $form = SettingForm::createFromModel($customer)
            ->renderForm();

        $payoutInformationForm = PayoutInformationForm::createFromModel($customer)
            ->setUrl(route('car-rentals.vendor.settings.post.payout'))
            ->renderForm();

        return CarRentalsHelper::view(
            'vendor-dashboard.settings.form',
            compact('customer', 'form', 'payoutInformationForm')
        );
    }

    public function update(SettingRequest $request)
    {
        /**
         * @var Customer $customer
         */
        $customer = auth('customer')->user();

        SettingForm::createFromModel($customer)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('car-rentals.vendor.settings.index'))
            ->withUpdatedSuccessMessage();
    }

    public function updatePayoutInformation(PayoutInformationSettingRequest $request)
    {
        /**
         * @var Customer $customer
         */
        $customer = auth('customer')->user();

        if ($customer && $customer->id) {
            $customer->payout_payment_method = $request->input('payout_payment_method');
            $customer->bank_info = $request->input('bank_info', []);
            $customer->save();
        }

        return $this
            ->httpResponse()
            ->setMessage(__('Update successfully!'))
            ->setNextUrl(route('car-rentals.vendor.settings.index'));
    }
}

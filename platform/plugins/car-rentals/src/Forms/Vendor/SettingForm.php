<?php

namespace Botble\CarRentals\Forms\Vendor;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Supports\Language;
use Botble\CarRentals\Http\Requests\Vendor\SettingRequest;
use Botble\CarRentals\Models\Customer;
use Illuminate\Support\Facades\App;

class SettingForm extends FormAbstract
{
    public function setup(): void
    {
        $languages = Language::getAvailableLocales();

        $languages = collect($languages)
            ->pluck('name', 'locale')
            ->map(fn ($item, $key) => $item . ' - ' . $key)
            ->all();

        $this
            ->setupModel(new Customer())
            ->setValidatorClass(SettingRequest::class)
            ->setUrl(route('car-rentals.vendor.settings.update'))
            ->setMethod('PUT')
            ->contentOnly()
            ->add(
                'locale',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Language'))
                    ->choices($languages)
                    ->selected($this->getModel()->getMetaData('locale', 'true') ?: App::getLocale())
                    ->metadata()
            );
    }
}

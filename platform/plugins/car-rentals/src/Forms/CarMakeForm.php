<?php

namespace Botble\CarRentals\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\CarRentals\Http\Requests\CarMakeRequest;
use Botble\CarRentals\Models\CarMake;

class CarMakeForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(CarMake::class)
            ->setValidatorClass(CarMakeRequest::class)
            ->withCustomFields()
            ->columns()
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required()
                    ->maxLength(120)
                    ->colspan(2)
            )
            ->add('logo', MediaImageField::class)
            ->add('status', SelectField::class, StatusFieldOption::make()->choices(BaseStatusEnum::labels()))
            ->setBreakFieldPoint('status');
    }
}

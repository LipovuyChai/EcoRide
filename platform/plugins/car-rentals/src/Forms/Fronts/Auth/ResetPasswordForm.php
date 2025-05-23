<?php

namespace Botble\CarRentals\Forms\Fronts\Auth;

use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\PasswordField;
use Botble\Base\Forms\Fields\TextField;
use Botble\CarRentals\Forms\Fronts\Auth\FieldOptions\EmailFieldOption;
use Botble\CarRentals\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\CarRentals\Http\Requests\Fronts\Auth\ResetPasswordRequest;

class ResetPasswordForm extends AuthForm
{
    public static function formTitle(): string
    {
        return __('Customer reset password form');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('customer.password.reset.post'))
            ->icon('ti ti-lock')
            ->setValidatorClass(ResetPasswordRequest::class)
            ->heading(__('Reset Password'))
            ->add(
                'token',
                'hidden',
                TextFieldOption::make()
                    ->value($this->request->route('token'))
            )
            ->add(
                'email',
                TextField::class,
                EmailFieldOption::make()
                    ->label(__('Email address'))
                    ->value($this->request->input('email'))
                    ->icon('ti ti-mail')
            )
            ->add(
                'password',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(__('Password'))
                    ->placeholder(__('Password'))
                    ->icon('ti ti-lock')
            )
            ->add(
                'password_confirmation',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(__('Password confirmation'))
                    ->placeholder(__('Password confirmation'))
                    ->icon('ti ti-lock')
            )
            ->submitButton(__('Reset Password'))
            ->add('back_to_login', HtmlField::class, [
                'html' => sprintf(
                    '<div class="mt-3 text-center"><a href="%s" class="text-decoration-underline">%s</a></div>',
                    route('customer.login'),
                    __('Back to login page')
                ),
            ]);
    }
}

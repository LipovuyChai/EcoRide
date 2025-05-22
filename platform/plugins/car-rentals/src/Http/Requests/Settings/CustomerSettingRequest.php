<?php

namespace Botble\CarRentals\Http\Requests\Settings;

use Botble\Base\Rules\OnOffRule;
use Botble\Support\Http\Requests\Request;

class CustomerSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'verify_customer_email' => $onOffRule = new OnOffRule(),
            'enabled_customer_registration' => $onOffRule,
            'show_terms_and_policy_acceptance_checkbox' => $onOffRule,
        ];
    }
}

<?php

namespace Botble\CarRentals\Http\Requests;

use Botble\CarRentals\Enums\RevenueTypeEnum;
use Botble\CarRentals\Models\Customer;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreRevenueRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'type' => Rule::in(RevenueTypeEnum::adjustValues()),
            'amount' => 'required|numeric|min:0|not_in:0',
            'description' => 'nullable|max:400',
        ];

        if ($this->input('type') == RevenueTypeEnum::SUBTRACT_AMOUNT) {
            $customer = Customer::query()->find($this->route('id'));
            if ($customer) {
                $rules['amount'] = 'numeric|min:0|max:' . $customer->balance;
            }
        }

        return $rules;
    }
}

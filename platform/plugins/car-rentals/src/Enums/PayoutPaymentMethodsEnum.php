<?php

namespace Botble\CarRentals\Enums;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Supports\Enum;
use Botble\CarRentals\Facades\CarRentalsHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rule;

/**
 * @method static PayoutPaymentMethodsEnum BANK_TRANSFER()
 * @method static PayoutPaymentMethodsEnum PAYPAL()
 */
class PayoutPaymentMethodsEnum extends Enum
{
    public const BANK_TRANSFER = 'bank_transfer';

    public const PAYPAL = 'paypal';

    public static $langPath = 'plugins/car-rentals::car-rentals.payout_payment_methods';

    public function toHtml(): HtmlString|string
    {
        $color = match ($this->value) {
            self::BANK_TRANSFER => 'info',
            default => 'primary',
        };

        return BaseHelper::renderBadge($this->label(), $color);
    }

    public static function payoutMethodsEnabled(): array
    {
        return Arr::where(static::payoutMethods(), fn ($item) => $item['is_enabled']);
    }

    public static function payoutMethods(): array
    {
        $data = [
            self::BANK_TRANSFER => [
                'is_enabled' => (bool) Arr::get(CarRentalsHelper::getSetting('payout_methods'), self::BANK_TRANSFER, true),
                'key' => self::BANK_TRANSFER,
                'label' => self::BANK_TRANSFER()->label(),
                'fields' => [
                    'name' => [
                        'title' => __('Bank Name'),
                        'rules' => 'max:120',
                    ],
                    'code' => [
                        'title' => __('Bank Code/IFSC'),
                        'rules' => 'max:120',
                    ],
                    'full_name' => [
                        'title' => __('Account Holder Name'),
                        'rules' => 'max:120',
                    ],
                    'number' => [
                        'title' => __('Account Number'),
                        'rules' => 'max:50',
                    ],
                    'upi_id' => [
                        'title' => __('UPI ID'),
                        'rules' => 'max:120',
                        'helper_text' => __('It is optional. If you have UPI ID, you can provide it here.'),
                    ],
                    'description' => [
                        'title' => __('Description'),
                        'rules' => 'max:500',
                    ],
                ],
            ],
            self::PAYPAL => [
                'is_enabled' => (bool) Arr::get(CarRentalsHelper::getSetting('payout_methods'), self::PAYPAL, true),
                'key' => self::PAYPAL,
                'label' => self::PAYPAL()->label(),
                'fields' => [
                    'paypal_id' => [
                        'title' => __('PayPal ID'),
                        'rules' => 'max:120',
                    ],
                ],
            ],
        ];

        return apply_filters('car_rentals_payout_methods', $data);
    }

    public static function getFields(?string $channel): array
    {
        if (! $channel || ! in_array($channel, array_keys(static::payoutMethods()))) {
            $channel = self::BANK_TRANSFER;
        }

        return Arr::get(static::payoutMethods(), $channel . '.fields');
    }

    public static function getRules(?string $prefix): array
    {
        $payoutMethodsEnabled = static::payoutMethodsEnabled();
        $rules = [
            'payout_payment_method' => Rule::in(array_keys($payoutMethodsEnabled)),
        ];

        if ($prefix) {
            $prefix = rtrim($prefix, '.');
            $rules[$prefix] = 'nullable|array:' . implode(',', array_keys($payoutMethodsEnabled));
            $prefix = $prefix . '.';
        }

        foreach ($payoutMethodsEnabled as $method) {
            if (empty($method['fields'])) {
                continue;
            }
            $rules[$prefix . $method['key']] = 'array:' . implode(',', array_keys($method['fields']));
            foreach ($method['fields'] as $key => $field) {
                $rules[$prefix . $method['key'] . '.' . $key] = Arr::get($field, 'rules', 'nullable');
            }
        }

        return $rules;
    }

    public static function getAttributes(?string $prefix): array
    {
        $attributes = [];
        if ($prefix) {
            $prefix = rtrim($prefix, '.');
            $attributes[$prefix] = __('Payout info');
            $prefix = $prefix . '.';
        }

        foreach (static::payoutMethodsEnabled() as $method) {
            $attributes[$prefix . $method['key']] = $method['label'];
            foreach ($method['fields'] as $key => $field) {
                $attributes[$prefix . $method['key'] . '.' . $key] = __('Payout info') . ' (' . Arr::get($field, 'title') . ')';
            }
        }

        return $attributes;
    }
}

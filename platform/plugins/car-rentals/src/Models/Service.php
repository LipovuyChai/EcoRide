<?php

namespace Botble\CarRentals\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Service extends BaseModel
{
    protected $table = 'cr_services';

    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'logo',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}

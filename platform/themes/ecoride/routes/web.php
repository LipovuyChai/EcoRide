<?php

use Botble\Base\Http\Middleware\RequiresJsonRequestMiddleware;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\EcoRide\Http\Controllers\EcoRideController;


Route::group(['controller' => EcoRideController::class, 'middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {



        Route::post('calculate-loan-car', [EcoRideController::class, 'calculateLoanCar'])->name('public.calculate-loan-car');

        Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.', 'middleware' => [RequiresJsonRequestMiddleware::class]], function () {
            Route::get('search-popular-vehicles', 'ajaxSearchPopularVehicles')
                ->name('search-popular-vehicles');
        });
    });
});

Theme::routes();

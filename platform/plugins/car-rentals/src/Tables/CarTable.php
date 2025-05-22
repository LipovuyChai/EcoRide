<?php

namespace Botble\CarRentals\Tables;

use Botble\Base\Facades\Html;
use Botble\CarRentals\Enums\CarPurposeEnum;
use Botble\CarRentals\Models\Car;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\EnumColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CarTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Car::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('car-rentals.cars.create'))
            ->addActions([
                EditAction::make()->route('car-rentals.cars.edit'),
                DeleteAction::make()->route('car-rentals.cars.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('car-rentals.cars.edit'),
                FormattedColumn::make('license_plate')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.license_plate'))
                    ->withEmptyState(),
                FormattedColumn::make('make.name')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.make'))
                    ->withEmptyState(),
                FormattedColumn::make('year')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.year'))
                    ->withEmptyState(),
                FormattedColumn::make('car_purpose')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.car_purpose'))
                    ->renderUsing(function (FormattedColumn $column) {
                        $purpose = $column->getItem()->car_purpose;

                        return (new CarPurposeEnum())->make($purpose)->toHtml();
                    })
                    ->orderable(false)
                    ->searchable(false),
                FormattedColumn::make('rental_rate')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.rental_rate'))
                    ->renderUsing(function (FormattedColumn $column) {
                        return Html::tag('strong', format_price($column->getItem()->rental_rate));
                    }),
                FormattedColumn::make('vin')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.vin'))
                    ->withEmptyState(),
                StatusColumn::make('status'),
                EnumColumn::make('moderation_status')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.moderation_status'))
                    ->width(150),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('car-rentals.cars.destroy'),
            ])
            ->queryUsing(function (Builder $query): void {
                $query
                    ->select([
                        'id',
                        'license_plate',
                        'make_id',
                        'name',
                        'year',
                        'mileage',
                        'rental_rate',
                        'insurance_info',
                        'vin',
                        'status',
                        'moderation_status',
                        'created_at',
                        'is_for_sale',
                    ])
                    ->with('make');
            });
    }
}

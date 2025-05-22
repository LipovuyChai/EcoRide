<?php

namespace Botble\CarRentals\Tables\Vendor;

use Botble\Base\Facades\Html;
use Botble\CarRentals\Models\Customer;
use Botble\CarRentals\Tables\CarTable as BaseCarTable;
use Botble\CarRentals\Tables\Traits\ForVendor;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CarTable extends BaseCarTable
{
    use ForVendor;

    public function setup(): void
    {
        parent::setup();

        $this
            ->removeColumns()
            ->removeAllActions()
            ->removeHeaderActions()
            ->addHeaderAction(
                CreateHeaderAction::make()
                    ->route('car-rentals.vendor.cars.create')
            )
            ->addActions([
                EditAction::make()->route('car-rentals.vendor.cars.edit'),
                DeleteAction::make()->route('car-rentals.vendor.cars.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('car-rentals.vendor.cars.edit'),
                Column::make('license_plate')->title(trans('plugins/car-rentals::car-rentals.car.forms.license_plate')),
                Column::make('make.name')->title(trans('plugins/car-rentals::car-rentals.car.forms.make')),
                Column::make('year')->title(trans('plugins/car-rentals::car-rentals.car.forms.year')),
                FormattedColumn::make('rental_rate')
                    ->title(trans('plugins/car-rentals::car-rentals.car.forms.rental_rate'))
                    ->renderUsing(function (FormattedColumn $column) {
                        return Html::tag('strong', format_price($column->getItem()->rental_rate));
                    }),
                Column::make('vin')->title(trans('plugins/car-rentals::car-rentals.car.forms.vin')),
                StatusColumn::make('status'),
                CreatedAtColumn::make(),
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
                        'status',
                        'insurance_info',
                        'vin',
                        'created_at',
                    ])
                    ->with('make')
                    ->where('author_type', Customer::class)
                    ->where('author_id', auth('customer')->id());
            });
    }

    public function bulkActions(): array
    {
        return [];
    }

    public function getBulkChanges(): array
    {
        return [];
    }

    public function hasBulkActions(): bool
    {
        return false;
    }
}

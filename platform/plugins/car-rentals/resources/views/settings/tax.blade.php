@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    {!! $form->renderForm() !!}

    <div class="mt-6">
        <x-core-setting::section
            :title="trans('plugins/car-rentals::settings.tax.tax_management')"
            :description="trans('plugins/car-rentals::settings.tax.tax_management_description')"
        >
            <div class="table-responsive">
                {!! $taxTable->render('core/table::base-table') !!}
            </div>
        </x-core-setting::section>
    </div>
@endsection

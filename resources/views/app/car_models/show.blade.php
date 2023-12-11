@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('car-models.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.car_models.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.car_models.inputs.name')</h5>
                    <span>{{ $carModel->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_models.inputs.car_company_id')</h5>
                    <span
                        >{{ optional($carModel->carCompany)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('car-models.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\CarModel::class)
                <a
                    href="{{ route('car-models.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\CarVersion::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Car Versions</h4>

            <livewire:car-model-car-versions-detail :carModel="$carModel" />
        </div>
    </div>
    @endcan
</div>
@endsection

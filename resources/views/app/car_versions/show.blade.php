@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('car-versions.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.car_versions.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.car_versions.inputs.car_model_id')</h5>
                    <span
                        >{{ optional($carVersion->carModel)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_versions.inputs.name')</h5>
                    <span>{{ $carVersion->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_versions.inputs.year')</h5>
                    <span>{{ $carVersion->year ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_versions.inputs.initial_price')</h5>
                    <span>{{ $carVersion->initial_price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_versions.inputs.photo')</h5>
                    <x-partials.thumbnail
                        src="{{ $carVersion->photo ? \Storage::url($carVersion->photo) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('car-versions.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\CarVersion::class)
                <a
                    href="{{ route('car-versions.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    @can('view-any', App\Models\CarOption::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Car Options</h4>

            <livewire:car-version-car-options-detail
                :carVersion="$carVersion"
            />
        </div>
    </div>
    @endcan
</div>
@endsection

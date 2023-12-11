@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('car-models.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.car_models.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('car-models.update', $carModel) }}"
                class="mt-4"
            >
                @include('app.car_models.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('car-models.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('car-models.create') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
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

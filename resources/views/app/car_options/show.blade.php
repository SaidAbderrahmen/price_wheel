@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('car-options.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.car_options.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.car_options.inputs.title')</h5>
                    <span>{{ $carOption->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_options.inputs.description')</h5>
                    <span>{{ $carOption->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_options.inputs.price')</h5>
                    <span>{{ $carOption->price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.car_options.inputs.car_version_id')</h5>
                    <span
                        >{{ optional($carOption->carVersion)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('car-options.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\CarOption::class)
                <a
                    href="{{ route('car-options.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection

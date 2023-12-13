<div>
    <div class="mb-4">
        @can('create', App\Models\CarVersion::class)
        <button class="btn btn-primary" wire:click="newCarVersion">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\CarVersion::class)
        <button
            class="btn btn-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal id="car-model-car-versions-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="carVersion.year"
                            label="Year"
                            wire:model="carVersion.year"
                            max="255"
                            placeholder="Year"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number
                            name="carVersion.initial_price"
                            label="Initial Price"
                            wire:model="carVersion.initial_price"
                            step="0.01"
                            placeholder="Initial Price"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <div
                            image-url="{{ $editing && $carVersion->photo ? \Storage::url($carVersion->photo) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                        >
                            <x-inputs.partials.label
                                name="carVersionPhoto"
                                label="Photo"
                            ></x-inputs.partials.label
                            ><br />

                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="carVersionPhoto"
                                    id="carVersionPhoto{{ $uploadIteration }}"
                                    wire:model="carVersionPhoto"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('carVersionPhoto')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @can('view-any', App\Models\CarOption::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">Car Options</h6>

                    <livewire:car-version-car-options-detail
                        :carVersion="$carVersion"
                    />
                </div>
            </div>
            @endcan @endif

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light float-left"
                    wire:click="$toggle('showingModal')"
                >
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="text-right">
                        @lang('crud.car_model_car_versions.inputs.year')
                    </th>
                    <th class="text-right">
                        @lang('crud.car_model_car_versions.inputs.initial_price')
                    </th>
                    <th class="text-left">
                        @lang('crud.car_model_car_versions.inputs.photo')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($carVersions as $carVersion)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $carVersion->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-right">{{ $carVersion->year ?? '-' }}</td>
                    <td class="text-right">
                        {{ $carVersion->initial_price ?? '-' }}
                    </td>
                    <td class="text-left">
                        <x-partials.thumbnail
                            src="{{ $carVersion->photo ? \Storage::url($carVersion->photo) : '' }}"
                        />
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $carVersion)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editCarVersion({{ $carVersion->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">{{ $carVersions->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

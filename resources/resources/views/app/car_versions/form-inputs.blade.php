@php $editing = isset($carVersion) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="car_model_id" label="Car Model" required>
            @php $selected = old('car_model_id', ($editing ? $carVersion->car_model_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Car Model</option>
            @foreach($carModels as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="year"
            label="Year"
            :value="old('year', ($editing ? $carVersion->year : ''))"
            max="255"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="initial_price"
            label="Initial Price"
            :value="old('initial_price', ($editing ? $carVersion->initial_price : ''))"
            step="0.01"
            placeholder="Initial Price"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $carVersion->photo ? \Storage::url($carVersion->photo) : '' }}')"
        >
            <x-inputs.partials.label
                name="photo"
                label="Photo"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="photo"
                    id="photo"
                    @change="fileChosen"
                />
            </div>

            @error('photo') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarModel;
use Illuminate\View\View;
use App\Models\CarVersion;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarModelCarVersionsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public CarModel $carModel;
    public CarVersion $carVersion;
    public $carVersionPhoto;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New CarVersion';

    protected $rules = [
        'carVersion.year' => ['required', 'numeric'],
        'carVersion.initial_price' => ['required', 'numeric'],
        'carVersion.name' => ['max:255', 'string'],
        'carVersionPhoto' => ['nullable', 'file'],
    ];

    public function mount(CarModel $carModel): void
    {
        $this->carModel = $carModel;
        $this->resetCarVersionData();
    }

    public function resetCarVersionData(): void
    {
        $this->carVersion = new CarVersion();

        $this->carVersionPhoto = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCarVersion(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.car_model_car_versions.new_title');
        $this->resetCarVersionData();

        $this->showModal();
    }

    public function editCarVersion(CarVersion $carVersion): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.car_model_car_versions.edit_title');
        $this->carVersion = $carVersion;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        if (!$this->carVersion->car_model_id) {
            $this->validate();
        } else {
            $this->validate([
                'carVersion.year' => ['required', 'numeric'],
                'carVersion.initial_price' => ['required', 'numeric'],
                'carVersion.name' => ['required', 'max:255', 'string'],
                'carVersionPhoto' => ['nullable', 'file'],
            ]);
        }

        if (!$this->carVersion->car_model_id) {
            $this->authorize('create', CarVersion::class);

            $this->carVersion->car_model_id = $this->carModel->id;
        } else {
            $this->authorize('update', $this->carVersion);
        }

        if ($this->carVersionPhoto) {
            $this->carVersion->photo = $this->carVersionPhoto->store('public');
        }

        $this->carVersion->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', CarVersion::class);

        collect($this->selected)->each(function (string $id) {
            $carVersion = CarVersion::findOrFail($id);

            if ($carVersion->photo) {
                Storage::delete($carVersion->photo);
            }

            $carVersion->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCarVersionData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->carModel->carVersions as $carVersion) {
            array_push($this->selected, $carVersion->id);
        }
    }

    public function render(): View
    {
        return view('livewire.car-model-car-versions-detail', [
            'carVersions' => $this->carModel->carVersions()->paginate(20),
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\CarOption;
use App\Models\CarVersion;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarVersionCarOptionsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public CarVersion $carVersion;
    public CarOption $carOption;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New CarOption';

    protected $rules = [
        'carOption.title' => ['required', 'max:255', 'string'],
        'carOption.description' => ['required', 'max:255', 'string'],
        'carOption.price' => ['required', 'numeric'],
    ];

    public function mount(CarVersion $carVersion): void
    {
        $this->carVersion = $carVersion;
        $this->resetCarOptionData();
    }

    public function resetCarOptionData(): void
    {
        $this->carOption = new CarOption();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCarOption(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.car_version_car_options.new_title');
        $this->resetCarOptionData();

        $this->showModal();
    }

    public function editCarOption(CarOption $carOption): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.car_version_car_options.edit_title');
        $this->carOption = $carOption;

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
        $this->validate();

        if (!$this->carOption->car_version_id) {
            $this->authorize('create', CarOption::class);

            $this->carOption->car_version_id = $this->carVersion->id;
        } else {
            $this->authorize('update', $this->carOption);
        }

        $this->carOption->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', CarOption::class);

        CarOption::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCarOptionData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->carVersion->carOptions as $carOption) {
            array_push($this->selected, $carOption->id);
        }
    }

    public function render(): View
    {
        return view('livewire.car-version-car-options-detail', [
            'carOptions' => $this->carVersion->carOptions()->paginate(20),
        ]);
    }
}

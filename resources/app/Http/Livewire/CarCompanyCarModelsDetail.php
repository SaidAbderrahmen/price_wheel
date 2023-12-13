<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarModel;
use Illuminate\View\View;
use App\Models\CarCompany;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarCompanyCarModelsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public CarCompany $carCompany;
    public CarModel $carModel;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New CarModel';

    protected $rules = [
        'carModel.name' => ['required', 'max:255', 'string'],
    ];

    public function mount(CarCompany $carCompany): void
    {
        $this->carCompany = $carCompany;
        $this->resetCarModelData();
    }

    public function resetCarModelData(): void
    {
        $this->carModel = new CarModel();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCarModel(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.car_company_car_models.new_title');
        $this->resetCarModelData();

        $this->showModal();
    }

    public function editCarModel(CarModel $carModel): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.car_company_car_models.edit_title');
        $this->carModel = $carModel;

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

        if (!$this->carModel->car_company_id) {
            $this->authorize('create', CarModel::class);

            $this->carModel->car_company_id = $this->carCompany->id;
        } else {
            $this->authorize('update', $this->carModel);
        }

        $this->carModel->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', CarModel::class);

        CarModel::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCarModelData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->carCompany->carModels as $carModel) {
            array_push($this->selected, $carModel->id);
        }
    }

    public function render(): View
    {
        return view('livewire.car-company-car-models-detail', [
            'carModels' => $this->carCompany->carModels()->paginate(20),
        ]);
    }
}

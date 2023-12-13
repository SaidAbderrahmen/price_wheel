<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\View\View;
use App\Models\CarCompany;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CarModelStoreRequest;
use App\Http\Requests\CarModelUpdateRequest;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', CarModel::class);

        $search = $request->get('search', '');

        $carModels = CarModel::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.car_models.index', compact('carModels', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', CarModel::class);

        $carCompanies = CarCompany::pluck('name', 'id');

        return view('app.car_models.create', compact('carCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarModelStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', CarModel::class);

        $validated = $request->validated();

        $carModel = CarModel::create($validated);

        return redirect()
            ->route('car-models.edit', $carModel)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CarModel $carModel): View
    {
        $this->authorize('view', $carModel);

        return view('app.car_models.show', compact('carModel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CarModel $carModel): View
    {
        $this->authorize('update', $carModel);

        $carCompanies = CarCompany::pluck('name', 'id');

        return view('app.car_models.edit', compact('carModel', 'carCompanies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CarModelUpdateRequest $request,
        CarModel $carModel
    ): RedirectResponse {
        $this->authorize('update', $carModel);

        $validated = $request->validated();

        $carModel->update($validated);

        return redirect()
            ->route('car-models.edit', $carModel)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        CarModel $carModel
    ): RedirectResponse {
        $this->authorize('delete', $carModel);

        $carModel->delete();

        return redirect()
            ->route('car-models.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

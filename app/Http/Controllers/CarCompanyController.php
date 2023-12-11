<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\CarCompany;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CarCompanyStoreRequest;
use App\Http\Requests\CarCompanyUpdateRequest;

class CarCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', CarCompany::class);

        $search = $request->get('search', '');

        $carCompanies = CarCompany::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.car_companies.index',
            compact('carCompanies', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', CarCompany::class);

        return view('app.car_companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarCompanyStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', CarCompany::class);

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $carCompany = CarCompany::create($validated);

        return redirect()
            ->route('car-companies.edit', $carCompany)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CarCompany $carCompany): View
    {
        $this->authorize('view', $carCompany);

        return view('app.car_companies.show', compact('carCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CarCompany $carCompany): View
    {
        $this->authorize('update', $carCompany);

        return view('app.car_companies.edit', compact('carCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CarCompanyUpdateRequest $request,
        CarCompany $carCompany
    ): RedirectResponse {
        $this->authorize('update', $carCompany);

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            if ($carCompany->logo) {
                Storage::delete($carCompany->logo);
            }

            $validated['logo'] = $request->file('logo')->store('public');
        }

        $carCompany->update($validated);

        return redirect()
            ->route('car-companies.edit', $carCompany)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        CarCompany $carCompany
    ): RedirectResponse {
        $this->authorize('delete', $carCompany);

        if ($carCompany->logo) {
            Storage::delete($carCompany->logo);
        }

        $carCompany->delete();

        return redirect()
            ->route('car-companies.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

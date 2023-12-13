<?php

namespace App\Http\Controllers;

use App\Models\CarOption;
use Illuminate\View\View;
use App\Models\CarVersion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CarOptionStoreRequest;
use App\Http\Requests\CarOptionUpdateRequest;

class CarOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', CarOption::class);

        $search = $request->get('search', '');

        $carOptions = CarOption::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.car_options.index', compact('carOptions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', CarOption::class);

        $carVersions = CarVersion::pluck('photo', 'id');

        return view('app.car_options.create', compact('carVersions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarOptionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', CarOption::class);

        $validated = $request->validated();

        $carOption = CarOption::create($validated);

        return redirect()
            ->route('car-options.edit', $carOption)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CarOption $carOption): View
    {
        $this->authorize('view', $carOption);

        return view('app.car_options.show', compact('carOption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CarOption $carOption): View
    {
        $this->authorize('update', $carOption);

        $carVersions = CarVersion::pluck('photo', 'id');

        return view(
            'app.car_options.edit',
            compact('carOption', 'carVersions')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CarOptionUpdateRequest $request,
        CarOption $carOption
    ): RedirectResponse {
        $this->authorize('update', $carOption);

        $validated = $request->validated();

        $carOption->update($validated);

        return redirect()
            ->route('car-options.edit', $carOption)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        CarOption $carOption
    ): RedirectResponse {
        $this->authorize('delete', $carOption);

        $carOption->delete();

        return redirect()
            ->route('car-options.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

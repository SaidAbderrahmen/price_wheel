<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\View\View;
use App\Models\CarVersion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CarVersionStoreRequest;
use App\Http\Requests\CarVersionUpdateRequest;

class CarVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', CarVersion::class);

        $search = $request->get('search', '');

        $carVersions = CarVersion::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.car_versions.index', compact('carVersions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', CarVersion::class);

        $carModels = CarModel::pluck('name', 'id');

        return view('app.car_versions.create', compact('carModels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarVersionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', CarVersion::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $carVersion = CarVersion::create($validated);

        return redirect()
            ->route('car-versions.edit', $carVersion)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CarVersion $carVersion): View
    {
        $this->authorize('view', $carVersion);

        return view('app.car_versions.show', compact('carVersion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CarVersion $carVersion): View
    {
        $this->authorize('update', $carVersion);

        $carModels = CarModel::pluck('name', 'id');

        return view(
            'app.car_versions.edit',
            compact('carVersion', 'carModels')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CarVersionUpdateRequest $request,
        CarVersion $carVersion
    ): RedirectResponse {
        $this->authorize('update', $carVersion);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            if ($carVersion->photo) {
                Storage::delete($carVersion->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $carVersion->update($validated);

        return redirect()
            ->route('car-versions.edit', $carVersion)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        CarVersion $carVersion
    ): RedirectResponse {
        $this->authorize('delete', $carVersion);

        if ($carVersion->photo) {
            Storage::delete($carVersion->photo);
        }

        $carVersion->delete();

        return redirect()
            ->route('car-versions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

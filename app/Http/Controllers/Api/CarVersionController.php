<?php

namespace App\Http\Controllers\Api;

use App\Models\CarVersion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CarVersionResource;
use App\Http\Resources\CarVersionCollection;
use App\Http\Requests\CarVersionStoreRequest;
use App\Http\Requests\CarVersionUpdateRequest;

class CarVersionController extends Controller
{
    public function index(Request $request): CarVersionCollection
    {
        $this->authorize('view-any', CarVersion::class);

        $search = $request->get('search', '');

        $carVersions = CarVersion::search($search)
            ->latest()
            ->paginate();

        return new CarVersionCollection($carVersions);
    }

    public function store(CarVersionStoreRequest $request): CarVersionResource
    {
        $this->authorize('create', CarVersion::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $carVersion = CarVersion::create($validated);

        return new CarVersionResource($carVersion);
    }

    public function show(
        Request $request,
        CarVersion $carVersion
    ): CarVersionResource {
        $this->authorize('view', $carVersion);

        return new CarVersionResource($carVersion);
    }

    public function update(
        CarVersionUpdateRequest $request,
        CarVersion $carVersion
    ): CarVersionResource {
        $this->authorize('update', $carVersion);

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($carVersion->photo) {
                Storage::delete($carVersion->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $carVersion->update($validated);

        return new CarVersionResource($carVersion);
    }

    public function destroy(Request $request, CarVersion $carVersion): Response
    {
        $this->authorize('delete', $carVersion);

        if ($carVersion->photo) {
            Storage::delete($carVersion->photo);
        }

        $carVersion->delete();

        return response()->noContent();
    }
}

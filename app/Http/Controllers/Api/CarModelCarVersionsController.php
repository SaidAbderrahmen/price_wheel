<?php

namespace App\Http\Controllers\Api;

use App\Models\CarModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarVersionResource;
use App\Http\Resources\CarVersionCollection;

class CarModelCarVersionsController extends Controller
{
    public function index(
        Request $request,
        CarModel $carModel
    ): CarVersionCollection {
        $this->authorize('view', $carModel);

        $search = $request->get('search', '');

        $carVersions = $carModel
            ->carVersions()
            ->search($search)
            ->latest()
            ->paginate();

        return new CarVersionCollection($carVersions);
    }

    public function store(
        Request $request,
        CarModel $carModel
    ): CarVersionResource {
        $this->authorize('create', CarVersion::class);

        $validated = $request->validate([
            'photo' => ['nullable', 'file'],
            'name' => ['max:255', 'string'],
            'year' => ['required', 'numeric'],
            'initial_price' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $carVersion = $carModel->carVersions()->create($validated);

        return new CarVersionResource($carVersion);
    }
}

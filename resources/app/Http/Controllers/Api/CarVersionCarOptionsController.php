<?php

namespace App\Http\Controllers\Api;

use App\Models\CarVersion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarOptionResource;
use App\Http\Resources\CarOptionCollection;

class CarVersionCarOptionsController extends Controller
{
    public function index(
        Request $request,
        CarVersion $carVersion
    ): CarOptionCollection {
        $this->authorize('view', $carVersion);

        $search = $request->get('search', '');

        $carOptions = $carVersion
            ->carOptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new CarOptionCollection($carOptions);
    }

    public function store(
        Request $request,
        CarVersion $carVersion
    ): CarOptionResource {
        $this->authorize('create', CarOption::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $carOption = $carVersion->carOptions()->create($validated);

        return new CarOptionResource($carOption);
    }
}

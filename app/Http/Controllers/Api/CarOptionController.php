<?php

namespace App\Http\Controllers\Api;

use App\Models\CarOption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarOptionResource;
use App\Http\Resources\CarOptionCollection;
use App\Http\Requests\CarOptionStoreRequest;
use App\Http\Requests\CarOptionUpdateRequest;

class CarOptionController extends Controller
{
    public function index(Request $request): CarOptionCollection
    {
        $this->authorize('view-any', CarOption::class);

        $search = $request->get('search', '');

        $carOptions = CarOption::search($search)
            ->latest()
            ->paginate();

        return new CarOptionCollection($carOptions);
    }

    public function store(CarOptionStoreRequest $request): CarOptionResource
    {
        $this->authorize('create', CarOption::class);

        $validated = $request->validated();

        $carOption = CarOption::create($validated);

        return new CarOptionResource($carOption);
    }

    public function show(
        Request $request,
        CarOption $carOption
    ): CarOptionResource {
        $this->authorize('view', $carOption);

        return new CarOptionResource($carOption);
    }

    public function update(
        CarOptionUpdateRequest $request,
        CarOption $carOption
    ): CarOptionResource {
        $this->authorize('update', $carOption);

        $validated = $request->validated();

        $carOption->update($validated);

        return new CarOptionResource($carOption);
    }

    public function destroy(Request $request, CarOption $carOption): Response
    {
        $this->authorize('delete', $carOption);

        $carOption->delete();

        return response()->noContent();
    }
}

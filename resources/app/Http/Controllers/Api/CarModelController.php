<?php

namespace App\Http\Controllers\Api;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarModelResource;
use App\Http\Resources\CarModelCollection;
use App\Http\Requests\CarModelStoreRequest;
use App\Http\Requests\CarModelUpdateRequest;

class CarModelController extends Controller
{
    public function index(Request $request): CarModelCollection
    {
        $this->authorize('view-any', CarModel::class);

        $search = $request->get('search', '');

        $carModels = CarModel::search($search)
            ->latest()
            ->paginate();

        return new CarModelCollection($carModels);
    }

    public function store(CarModelStoreRequest $request): CarModelResource
    {
        $this->authorize('create', CarModel::class);

        $validated = $request->validated();

        $carModel = CarModel::create($validated);

        return new CarModelResource($carModel);
    }

    public function show(Request $request, CarModel $carModel): CarModelResource
    {
        $this->authorize('view', $carModel);

        return new CarModelResource($carModel);
    }

    public function update(
        CarModelUpdateRequest $request,
        CarModel $carModel
    ): CarModelResource {
        $this->authorize('update', $carModel);

        $validated = $request->validated();

        $carModel->update($validated);

        return new CarModelResource($carModel);
    }

    public function destroy(Request $request, CarModel $carModel): Response
    {
        $this->authorize('delete', $carModel);

        $carModel->delete();

        return response()->noContent();
    }
}

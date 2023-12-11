<?php

namespace App\Http\Controllers\Api;

use App\Models\CarCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CarCompanyResource;
use App\Http\Resources\CarCompanyCollection;
use App\Http\Requests\CarCompanyStoreRequest;
use App\Http\Requests\CarCompanyUpdateRequest;

class CarCompanyController extends Controller
{
    public function index(Request $request): CarCompanyCollection
    {
        $this->authorize('view-any', CarCompany::class);

        $search = $request->get('search', '');

        $carCompanies = CarCompany::search($search)
            ->latest()
            ->paginate();

        return new CarCompanyCollection($carCompanies);
    }

    public function store(CarCompanyStoreRequest $request): CarCompanyResource
    {
        $this->authorize('create', CarCompany::class);

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $carCompany = CarCompany::create($validated);

        return new CarCompanyResource($carCompany);
    }

    public function show(
        Request $request,
        CarCompany $carCompany
    ): CarCompanyResource {
        $this->authorize('view', $carCompany);

        return new CarCompanyResource($carCompany);
    }

    public function update(
        CarCompanyUpdateRequest $request,
        CarCompany $carCompany
    ): CarCompanyResource {
        $this->authorize('update', $carCompany);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($carCompany->logo) {
                Storage::delete($carCompany->logo);
            }

            $validated['logo'] = $request->file('logo')->store('public');
        }

        $carCompany->update($validated);

        return new CarCompanyResource($carCompany);
    }

    public function destroy(Request $request, CarCompany $carCompany): Response
    {
        $this->authorize('delete', $carCompany);

        if ($carCompany->logo) {
            Storage::delete($carCompany->logo);
        }

        $carCompany->delete();

        return response()->noContent();
    }
}

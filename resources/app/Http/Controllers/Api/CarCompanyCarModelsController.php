<?php

namespace App\Http\Controllers\Api;

use App\Models\CarCompany;
use App\Models\CarModel;
use App\Models\CarVersion;
use App\Models\CarOption;
use App\Http\Controllers\Controller;

class CarCompanyCarModelsController extends Controller
{

    public function allCarData() :  array {
        //without timestamps
        $carCompany = CarCompany::all()->makeHidden(['created_at', 'updated_at']);
        $carModel = CarModel::all()->makeHidden(['created_at', 'updated_at']);
        $carVersion = CarVersion::all()->makeHidden(['created_at', 'updated_at']);
        $carOption = CarOption::all()->makeHidden(['created_at', 'updated_at']);


        return [
            'carCompany' => $carCompany,
            'carModel' => $carModel,
            'carVersion' => $carVersion,
            'carOption' => $carOption
        ];

       
        
    }
    // public function index(
    //     Request $request,
    //     CarCompany $carCompany
    // ): CarModelCollection {
    //     $this->authorize('view', $carCompany);

    //     $search = $request->get('search', '');

    //     $carModels = $carCompany
    //         ->carModels()
    //         ->search($search)
    //         ->latest()
    //         ->paginate();

    //     return new CarModelCollection($carModels);
    // }

    // public function store(
    //     Request $request,
    //     CarCompany $carCompany
    // ): CarModelResource {
    //     $this->authorize('create', CarModel::class);

    //     $validated = $request->validate([
    //         'name' => ['required', 'max:255', 'string'],
    //     ]);

    //     $carModel = $carCompany->carModels()->create($validated);

    //     return new CarModelResource($carModel);
    // }
}

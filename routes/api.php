<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarModelController;
use App\Http\Controllers\Api\CarOptionController;
use App\Http\Controllers\Api\CarCompanyController;
use App\Http\Controllers\Api\CarVersionController;
use App\Http\Controllers\Api\CarCompanyCarModelsController;
use App\Http\Controllers\Api\CarModelCarVersionsController;
use App\Http\Controllers\Api\CarVersionCarOptionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

//get all car data
Route::get('/allCarData', [CarCompanyCarModelsController::class, 'allCarData'])->name('api.allCarData');
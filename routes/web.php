<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CarOptionController;
use App\Http\Controllers\CarCompanyController;
use App\Http\Controllers\CarVersionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('car-companies', CarCompanyController::class);
        Route::resource('car-models', CarModelController::class);
        Route::resource('car-versions', CarVersionController::class);
        Route::resource('car-options', CarOptionController::class);
        Route::resource('users', UserController::class);
    });

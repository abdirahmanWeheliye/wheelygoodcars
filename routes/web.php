<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/aanbod', [CarController::class, 'create'])->name('aanbod.create');
    Route::post('/aanbod', [CarController::class, 'store'])->name('aanbod.store');

    Route::get('/mijn-autos', [CarController::class, 'myCars'])->name('car.myCars');
    Route::delete('/mijn-autos/{car}', [CarController::class, 'destroy'])->name('car.destroy');
});

require __DIR__ . '/auth.php';

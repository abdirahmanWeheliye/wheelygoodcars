<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\TagController;
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

    Route::get('/rdw/{license_plate}', [CarController::class, 'fetchFromRdw'])->name('car.fetchRdw');

    Route::get('/auto/{car}/pdf', [CarController::class, 'generatePdf'])->name('car.pdf');

    Route::get('/admin/tags-overzicht', [TagController::class, 'index'])->name('admin.tags_overview');

    Route::post('/cars/{car}/update-price', [CarController::class, 'updatePrice'])->name('car.updatePrice');
    Route::post('/cars/{car}/toggle-status', [CarController::class, 'toggleStatus'])->name('car.toggleStatus');
});

Route::get('/aanbod', [CarController::class, 'publicIndex'])->name('car.publicIndex');
require __DIR__ . '/auth.php';

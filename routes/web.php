<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\DriverController;


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
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect("taxiritten");
    })->name('dashboard');
    Route::get('/taxiritten', [RideController::class, 'index'])->name('taxiritten');
    Route::get('/chauffeurbeheer', [DriverController::class, 'index'])->name('chauffeurbeheer');
    Route::get('/werktijden/{driverId}', [DriverController::class, 'getWorkshifts'])->name('werktijden');
});


 Route::post('/login', [LoginController::class, 'login'])->name('login');

<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', fn () => Auth::check() ? redirect()->route('home') : redirect()->route('login'))->name('root');
    Route::get('/register', fn () => abort(403, 'Registration is not allowed.'))->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/multi-delete', [BookingController::class, 'multiDelete'])->name('bookings.multi-delete');
    Route::resource('tours', TourController::class);
    Route::post('/tours/multi-delete', [TourController::class, 'multiDelete'])->name('tours.multi-delete');
});

Auth::routes();
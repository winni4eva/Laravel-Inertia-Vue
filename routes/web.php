<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('HomePage/HomePage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'maxRating' => config('app.maxRating')
    ]);
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::post('companies/{company}/rate', RatingController::class)
    ->middleware('auth:sanctum')
    ->name('company.name');

Route::post('companies/manager/{manager}', [App\Http\Controllers\CompanyController::class, 'store'])
    ->name('companies.store');
Route::put('companies/{company}/manager/{manager}', [App\Http\Controllers\CompanyController::class, 'update'])
    ->name('companies.update');
Route::resource('companies', CompanyController::class)->except(['store', 'update']);

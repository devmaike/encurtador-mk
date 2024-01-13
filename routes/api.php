<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/urls', [UrlsController::class, 'store'])->name('urls.store')->middleware('request.guardian');
Route::get('/{code}/status', [UrlsController::class, 'show'])->name('urls.show');
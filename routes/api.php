<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CountryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::get('/products/{type}', [ProductController::class, 'getByType']);
Route::get('/search/{type}', [ProductController::class, 'search']);
Route::get('/brands/{type}', [ProductController::class, 'allBrands']);
Route::get('/categories/{type}', [ProductController::class, 'allCategories']);


Route::get('/countries', [CountryController::class, 'index']);

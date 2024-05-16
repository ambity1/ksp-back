<?php

use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeController;
use \App\Http\Controllers\ProductController;


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

Route::any('/1c_exchange', [ExchangeController::class, 'exchange']);

Route::get('/product/{id}', [ProductController::class, 'getProductByID']);

Route::post('/products', [ProductController::class, 'getProducts']);

Route::post('/products/filter', [ProductController::class, 'getProductsFilterPrice']);

//Route::get('/products/w/p', [ProductController::class, 'getProductsWithoutPrice']);

Route::get('/products/random', [ProductController::class, 'getProductsRandom']);

//Route::get('/product/find/{name}/{typeSort}/{sort}/{limit}/{from}/{to}', [ProductController::class, 'getProductsFind']);

Route::get('/promotion/{id}', [PromotionController::class, 'getPromotionByID']);
Route::get('/promotions', [PromotionController::class, 'getPromotions']);


Route::post('/request', [RequestController::class, 'requestTG']);

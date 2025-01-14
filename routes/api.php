<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
	Route::post('/user/logout', [UserController::class, 'logout']);
	Route::get('/breweries', 'App\Http\Controllers\BreweryController@getList')->name('getBrewery');
	Route::get('/breweries/meta', 'App\Http\Controllers\BreweryController@getMeta')->name('getMeta');
});
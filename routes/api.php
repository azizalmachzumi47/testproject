<?php

use App\Http\Controllers\AuthapiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Datamhs_apiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthapiController::class, 'login']);
    Route::post('register', [AuthapiController::class, 'register']);
    Route::post('logout', [AuthapiController::class,'logout']);
});

Route::group(['prefix' => 'datamhs'], function () {
    Route::get('/', [Datamhs_apiController::class, 'index']);
    Route::get('{id}', [Datamhs_apiController::class, 'show']);
    Route::post('/', [Datamhs_apiController::class, 'store']);
    Route::put('{id}', [Datamhs_apiController::class, 'update']);
    Route::delete('{id}', [Datamhs_apiController::class, 'destroy']);

    // Rute pencarian
    Route::get('/search/nim/{nim}', [Datamhs_apiController::class, 'searchByNim']);
    Route::get('/search/name/{name}', [Datamhs_apiController::class, 'searchByName']);
    Route::get('/search/date/{date}', [Datamhs_apiController::class, 'searchByDate']);
    
});

Route::get('/fetch-career-data', [Datamhs_apiController::class, 'fetchData']);



Route::middleware(['auth:api'])->group(function(){
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('logout', [AuthController::class,'logout']);

});
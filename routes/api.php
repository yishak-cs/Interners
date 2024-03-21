<?php

use App\Http\Controllers\ConfigsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** internship api's */
Route::get('/internship', [InternshipController::class, 'apiIndex']);
Route::get('/internship/{query}', [InternshipController::class, 'apiSearchIndex']);

/** admin config api's */
Route::middleware('auth:sanctum')->group(function(){
    // node
    Route::prefix('/node')->group(function (){
        Route::post('/start', [ConfigsController::class, 'startServer']);
        Route::post('/stop', [ConfigsController::class, 'stopServer']);
        Route::get('/get', [ConfigsController::class, 'getValues']);
    });
});

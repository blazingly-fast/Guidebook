<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuidebookController;
use App\Http\Controllers\PlacesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

	Route::post('/logout', [AuthController::class, 'logout']);

	Route::get('/guidebooks', [GuidebookController::class, 'index']);
	Route::get('/guidebooks-by-user', [GuidebookController::class, 'getAllByUser']);
	Route::get('/guidebooks/{id}', [GuidebookController::class, 'show']);
	Route::post('/guidebooks', [GuidebookController::class, 'store']);
	Route::put('/guidebooks/{guidebook}', [GuidebookController::class, 'update']);
	Route::delete('/guidebooks/{guidebook}', [GuidebookController::class, 'destroy']);

	// Places routes
	Route::get('/guidebooks/places/{guidebook}', [PlacesController::class, 'index']);
	Route::get('/guidebooks/place/{place}', [PlacesController::class, 'show']);
	Route::post('/guidebooks/place', [PlacesController::class, 'store']);
	Route::put('/guidebooks/place/{place}', [PlacesController::class, 'update']);
	Route::delete('/guidebooks/place/{place}', [PlacesController::class, 'destroy']);
});

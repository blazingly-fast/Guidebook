<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuidebookController;
use App\Http\Controllers\PlacesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/resend-verification', [AuthController::class], 'resendVerification')->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.reset');

// Protected routes
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/guidebooks-by-user', [GuidebookController::class, 'getAllByUser']);
  Route::get('/guidebooks', [GuidebookController::class, 'index']);
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

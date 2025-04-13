<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//Public Routes - User
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Public Routes - Appointment
// Route::get('/', AppointmentController::class . '@index')->name('posts.index');
// Route::get('/', AppointmentController::class . '@index')->name('posts.index');
Route::get('/', [AppointmentController::class, 'index']);
Route::get('/{id}', [AppointmentController::class, 'show']);
// Route::post('/', [AppointmentController::class, 'store']);
// Route::put('/{id}', [AppointmentController::class, 'update']);
// Route::delete('/{id}', [AppointmentController::class, 'destroy']);

//Private Routes
Route::middleware('auth:sanctum')->group(function () {
    //Provate Routes - User

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    //Private Routes - Appointment
    Route::post('/', [AppointmentController::class, 'store']);
    Route::put('/{id}', [AppointmentController::class, 'update']);
    Route::delete('/{id}', [AppointmentController::class, 'destroy']);

    //Private Routes - Search
    Route::get('/appointments/search', [AppointmentController::class, 'search']);
});

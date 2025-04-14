<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// say hello
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API',
        'status' => 'success',
    ], 200);
});

// debug - rute hanya untuk pengembangan
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::get('/test', [AuthController::class, 'test']);

// register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// rute untuk kehadiran karyawan
Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
Route::put('/attendance/check-out/{id}', [AttendanceController::class, 'checkOut']);
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', [AuthController::class, 'getAllUsers']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', [AuthController::class, 'test']);

Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
Route::put('/attendance/check-out/{id}', [AttendanceController::class, 'checkOut']);
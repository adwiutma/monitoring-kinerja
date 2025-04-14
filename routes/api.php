<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\TaskScheduleController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);
    Route::get('/attendance/history', [AttendanceController::class, 'history']);
    Route::get('/schedule/report', [TaskScheduleController::class, 'report']);
    Route::post('/feedback', [FeedbackController::class, 'store']); //untuk manajer
    Route::get('/feedback', [FeedbackController::class, 'UserFeedback']); //untuk Karyawan
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead']);
});


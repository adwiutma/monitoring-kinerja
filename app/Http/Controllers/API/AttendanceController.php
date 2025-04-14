<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
    $user = $request->user();
    $today = now()->toDateString();

    $attendance = Attendance::firstOrCreate(
        ['user_id' => $user->id, 'date' => $today],
        ['check_in' => now()->format('H:i:s')]
    );

    if ($attendance->wasRecentlyCreated) {
        return response()->json(['message' => 'Berhasil check-in', 'data' => $attendance]);
    }

    return response()->json(['message' => 'Kamu sudah check-in hari ini'], 400);
    }

    public function checkOut(Request $request)
    {
    $user = $request->user();
    $today = now()->toDateString();

    $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

    if (!$attendance || !$attendance->check_in) {
        return response()->json(['message' => 'Belum check-in'], 400);
    }

    if ($attendance->check_out) {
        return response()->json(['message' => 'Sudah check-out'], 400);
    }

    $attendance->check_out = now()->format('H:i:s');
    $attendance->save();

    return response()->json(['message' => 'Berhasil check-out', 'data' => $attendance]);
    }

    public function history(Request $request)
    {
    $user = $request->user();
    $attendances = Attendance::where('user_id', $user->id)
        ->orderBy('date', 'desc')
        ->limit(30)
        ->get();

    return response()->json(['data' => $attendances]);
    }
}

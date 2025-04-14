<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TaskScheduleController extends Controller
{
    // Tampilkan semua tugas user
    public function index()
    {
        $user = Auth::user();
        $tasks = Schedule::where('user_id', $user->id)->orderBy('due_date', 'asc')->get();
        return response()->json(['data' => $tasks]);
    }

    // Tambah tugas baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task = Schedule::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
        ]);

        return response()->json(['message' => 'Tugas berhasil dibuat', 'data' => $task], 201);
    }

    // Update tugas (status / detail)
    public function update(Request $request, $id)
    {
        $task = Schedule::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $task->update($request->only(['title', 'description', 'status', 'due_date']));

        return response()->json(['message' => 'Tugas berhasil diperbarui', 'data' => $task]);
    }

    // Hapus tugas
    public function destroy($id)
    {
        $task = Schedule::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $task->delete();

        return response()->json(['message' => 'Tugas berhasil dihapus']);
    }

    // Tampilkan tugas hari ini
    public function today()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $tasks = Schedule::where('user_id', $user->id)
                     ->whereDate('due_date', $today)
                     ->get();

        return response()->json(['data' => $tasks]);
    }

public function report(Request $request)
{
    $userId = $request->user()->id;

    // 1. Hitung jumlah tugas berdasarkan status
    $statusCount = Schedule::where('user_id', $userId)
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->pluck('total', 'status');

    // 2. Ambil data produktivitas bulanan
    $monthlyData = Schedule::where('user_id', $userId)
        ->whereYear('due_date', now()->year)
        ->select(
            DB::raw('MONTH(due_date) as month'),
            DB::raw('count(*) as total'),
            DB::raw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed")
        )
        ->groupBy(DB::raw('MONTH(due_date)'))
        ->get();

    // 3. Hitung poin kinerja (misalnya: 10 poin per tugas selesai)
    $totalCompleted = $statusCount['completed'] ?? 0;
    $points = $totalCompleted * 10;

    return response()->json([
        'status_count' => $statusCount,
        'monthly_productivity' => $monthlyData,
        'performance_points' => $points,
            'message' => 'Laporan kinerja berhasil diambil'
        ]);
    }
}
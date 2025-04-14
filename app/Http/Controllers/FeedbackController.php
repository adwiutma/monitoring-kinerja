<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'message' => 'required|string',
        'date' => 'required|date',
    ]);

    $feedback = Feedback::create([
        'user_id' => $validated['user_id'],
        'manager_id' => auth()->id(),
        'message' => $validated['message'],
        'date' => $validated['date'],
    ]);

    return response()->json(['message' => 'Feedback berhasil ditambahkan', 'data' => $feedback]);
}

public function userFeedback()
{
    $feedback = Feedback::where('user_id', auth()->id())
        ->orderBy('date', 'desc')
        ->get();

    return response()->json(['data' =>$feedback]);
}
}

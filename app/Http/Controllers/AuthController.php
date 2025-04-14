<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function getUserIdentity(Request $request){
        $user = $request->user();
        $userIdentity = Identity::where('user_id', $user->id)->first();

        return response()->json([
            'user' => $user,
            'identity' => $userIdentity,
        ], 200);
    }

    public function addIdentity(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'position_id' => 'required|exists:positions,id',
            'division_id' => 'required|exists:divisions,id',
            'profile_picture' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // buat detail identitas karyawan baru
        $identity = Identity::create($validator->validated());
        return response()->json(['identity' => $identity], 201);
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('Personal Access Token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function getAllUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function test()
    {
        return response()->json(['message' => 'Hello, World!'], 200);
    }
}

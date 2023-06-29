<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            $user = new User($request->validated());
            $user->save();
            // Create personal access token for the user
            $token = $user->createToken('MyAppToken')->accessToken;
            // Commit the transaction
            DB::commit();
            return ApiResponse::success($user,'Registration successful', 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();
            return ApiResponse::error('Registration failed', 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            if (!Auth::attempt($credentials)) {
                return ApiResponse::error('Invalid credentials', 401);
            }
            $user = User::where('email', $request->email)->first();
            if(!$user) return ApiResponse::error('User not found', 404);
            // Create personal access token for the user
            $token = $user->createToken('MyAppToken')->accessToken;
            $user['token'] = $token;
            return ApiResponse::success(['user' => $user], 'Login successful', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Login failed', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return ApiResponse::success('Logout successful', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Logout failed', 500);
        }
    }
}

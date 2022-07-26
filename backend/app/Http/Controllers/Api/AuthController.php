<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated_data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'first_name' => $validated_data['first_name'],
            'last_name' => $validated_data['last_name'],
            'display_name' => $validated_data['display_name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
        ]);

        return response(
            [
                'status' => 'Success',
                'message' => 'You have been successfully Registration.'
            ],
            200
        );
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response(
                [
                    'status' => 'Error',
                    'message' => 'Invalid login details'
                ],
                401
            );
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(
            [
                'status' => 'Success',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
            200
        );
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response(
            [
                'status' => 'Success',
                'message' => 'You have been successfully logged out.'
            ],
            200
        );
    }
}

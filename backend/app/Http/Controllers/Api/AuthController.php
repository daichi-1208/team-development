<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * 新規登録
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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

    /**
     * ログイン
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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

    /**
     * ログアウト
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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

    /**
     * パスワードリセット依頼
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function forgot_password(Request$request)
    {
        $validated_data = $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $status = Password::sendResetLink([
            'email' => $validated_data['email']
        ]);

        if ($status === Password::PASSWORD_RESET) {
            return response(
                [
                    'status' => $status
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => $status
                ],
                500
            );
        }

    }

    /**
     * パスワードリセット
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function reset_password(Request $request)
    {
        $credentials = request()->only(['email', 'token', 'password']);

        $status = Password::reset($credentials, function (User $user, string $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return response(
                [
                    'status' => __($status)
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => __($status)
                ],
                500
            );
        }
    }
}

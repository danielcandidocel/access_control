<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function __construct() { }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $token = $request->user()->createToken('auth_token', ['*'], now()->addWeek());

            return response()->json([
                                        'access_token' => $token->plainTextToken,
                                        'token_type'   => 'Bearer',
                                    ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}

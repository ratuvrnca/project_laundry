<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($token = auth()->attempt($credentials)) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ])->header('Authorization', $token)
                ->header('Access-Control-Allow-Headers', 'Authorization')
                ->header('Access-Control-Expose-Headers', 'Authorization');
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        Auth::guard()->logout();
        return response()->json(['success' => 'Logged out successfully'], 200);
    }

    public function user()
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}

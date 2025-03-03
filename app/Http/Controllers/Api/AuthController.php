<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)){
            $token = Auth::user()->createToken('token-name')->plainTextToken;
            return response()->json([
                'user' => new UserResource(Auth::user()),
                'token' => $token,
                'status' => 200
            ]);
        }

        return response()->json([
            'message' => "Email ou senha inválidos",
            'status' => 205
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'message' => 'successful',
            
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'dob' => $user->dob,
                    'dob' => $user->dob,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'status' => $user->status
                ],
                
                
            ],
            'code' => '200',
        ]);
    }

    public function register(Request $request)
    {
     $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|string|max:40',
            'gender' => 'required|string|max:40',
            'mobile' => 'required|string|max:20',     
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:20',
        ]);
        $user = User::create([
            'name' => $request->name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'status' => '1',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}

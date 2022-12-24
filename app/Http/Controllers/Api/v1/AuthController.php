<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $id = Auth::user()->id;
            $user = User::findOrFail($id);

            $token =  $user->createToken('dairy')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Login Success'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ], 422);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return
            response()->json([
                'user' => $user,
                'message' => 'User Added Successfully'
            ], 200);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Success'
        ], 200);
    }
}

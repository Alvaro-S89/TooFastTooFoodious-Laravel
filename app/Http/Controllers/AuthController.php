<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'direction' => $data['direction'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }
    
    public function login(LoginRequest $request){
        $data = $request->validated();

        //login vcalidation
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['Email o contraseña incorrectas']
            ], 422);
        }

        //user auth
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request){
        $user = $request-> user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}

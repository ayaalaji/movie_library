<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //here always the user how is doing register her role is user
    public function register(Request $request){
    $post_data = $request->validate([
        'name'=>'required|string',
        'email'=>'required|string|email|unique:users',
        'password'=>'required|min:8'
        
    ]);

    $user = User::create([
        'name' => $post_data['name'],
        'email' => $post_data['email'],
        'password' => Hash::make($post_data['password']),
        'role' =>'user'
    ]);

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}

    public function login(LoginRequest $request){
        $user = User::where('email', $request['email'])->firstOrFail();
        $role = $user->role;
        if($user->role =='admin'){
            if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
               'message' => 'Invalid login details'
            ], 401);
            }


            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'role' => $role
            ]);
        }else{
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                   'message' => 'Invalid login details'
                ], 401);
            }
            $token = $user->createToken('authToken')->plainTextToken; 
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'role' => $role,
            ]);
        }
    } 

 public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    
}
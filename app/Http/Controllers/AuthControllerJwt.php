<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
class AuthControllerJwt extends Controller
{
    //
    public function register(RegisterUserRequest $request){
        $request->validated();

        $user=User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' =>Hash::make( $request->password),
        ]);
        $token =Auth::login($user);
        return response()->json([
            'msg' => "done",
            "status"=>'success',
            'user'=>$user,
            'token'=>$token,
        ]);
    }
    public function login(LoginRequest $request)
    {
$request->validated();
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }
    public function logout(){
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',

        ]);

    }
}

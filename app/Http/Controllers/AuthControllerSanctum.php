<?php

namespace App\Http\Controllers;

use validator;
use App\Models\user;
use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;



class AuthControllerSanctum extends Controller
{
    //
    public function register(RegisterRequest $request){

     $validateor =  $request->validated();


         $user = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);
         $token=$user->createToken('MyApp')->plainTextToken;
         return response()->json([
            'status' =>true,
            'user'=> $user,
            'token' => $token,
            'msg' =>'User register successfully',
         ]);

    }

    public function login(LoginRequest $request){
      $credentials = $request->validated();

if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user =Auth::user();
            $token=$user->createToken('MyApp')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' =>$user
            ]);

        }

             return response()->json([
                'message' => 'Invalid login details'
            ], 401);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',

        ]);
    }
}

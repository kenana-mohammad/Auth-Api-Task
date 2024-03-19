<?php

namespace App\Http\Controllers;

use Auth;
use validator;
use Illuminate\Support\Facades\Hash;

use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\BaseController as BaseController;

class AuthControllerPassport extends BaseController

{
    //
       public function register(RegisterRequest $request){

       $validator=  $request->validated();


      $user= user::create([
        'name' => $request->name,
        'email' =>$request->email,
        'password'=> Hash::make($request->password)
      ]);
      $user['token'] =  $user->createToken('MyApp')->accessToken;

      return $this->SendResponse($user,200);
       }
       public function login(LoginRequest $request){
       $credintails= $request->validated();
         if(Auth::attempt($credintails)){
            $user=Auth::user();
            $user['token']=$user->createToken('MyApp')-> accessToken;
            return $this->SendResponse($user,200);

         }
       }

       public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
             return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',

        ]);
       }
}

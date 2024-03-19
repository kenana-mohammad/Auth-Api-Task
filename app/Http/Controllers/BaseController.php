<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    public function SendResponse($resault, $msg){
        $response = [
            'success' => true,
            'data'    => $resault,
            'message' => $msg,

        ];

        return response()->json($response,200);

    }
}

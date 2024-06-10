<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        try{

        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        try{
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)){
                //throw ValidationException::withMessages()
                return response()
                    ->json("Senha ou email invalido", 500);
            }
            $request->session()->put('auth_user', $user->id);
            $data['token'] = $user->createToken('browser')->plainTextToken;
            $data['token_expire'] = $data['tokenExpireTime'] = Carbon::now()->addMinutes(60)->isoFormat('Y-MM-DD HH:mm');
            return response()
                ->json($data);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function logOutAction(Request $request)
    {
        $request->session()->forget('auth_user');
        $request->user()->currentAccessToken()->delete();
    }
}

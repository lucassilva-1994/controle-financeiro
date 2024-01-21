<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel,Messages};
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use HelperModel, Messages;
    public function SignIn(Request $request)
    {
        if (User::whereEmail($request->email)->first()->active) {
            if (auth()->attempt($request->only('email', 'password'))) {
                $token = $request->user()->createToken('token')->accessToken;
                return response()->json($token);
            }
            return response()->json('Falha na autenticação');
        }
        return response()->json('Usuário inativo');
    }

    public function signUp(Request $request)
    {
        try {
            $user = self::setData($request->all(), User::class);
            return response()->json($user);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function whoAmI(){
        return User::with('payments','categories','clientsAndCreditors','releases')->whereId(auth()->user()->id)->get();
    }

    public function signOut()
    {
        if(auth()->user()->token()->delete()){
            return response()->json('Logout realizado com sucesso.');
        }
        return $this->messageFailed();
    }
}

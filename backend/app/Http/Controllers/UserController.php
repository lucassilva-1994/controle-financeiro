<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    use HelperModel;
    public function signIn(){
        //Permitindo que o usuário logue ou por e-mail ou por username
        $credentials = [
            'password' => request('password'),
            filter_var(request('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => request('login'),
        ];
        if(! $token = auth()->attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json($token,200);
    }

    public function signUp(UserRequest $request){
        if(self::createRecord(User::class, $request->all())){
            return response()->json(['message' => "Cadastro realizado com sucesso, foi enviado um link de ativação para o e-mail {$request->email}, o link expira em: ". now()->addDay(1)->format('d/m/y H:i:s')], 201);
        }  
    }

    public function signOut(){
        return 'SignOut';
    }
}

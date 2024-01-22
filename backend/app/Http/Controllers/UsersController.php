<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel,Messages};
use App\Http\Requests\UserRequest;
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
                return response()->json(['token' => 'Bearer '.$token,'user' => $request->user()]);
            }
            return response()->json(['message' => 'Usuário e senha inválidos.']);
        }
        return response()->json(['message' => 'Usuário inativo.']);
    }

    public function signUp(UserRequest $request)
    {
        try {
            $user = self::setData($request->all(), User::class);
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso.',
                'user'    => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function whoAmI(){
        return User::with('payments','categories','clientsAndCreditors','releases')->find(auth()->user()->id);
    }

    public function signOut()
    {
        if(auth()->user()->token()->delete()){
            return response()->json('Logout realizado com sucesso.');
        }
        return $this->messageFailed();
    }
}

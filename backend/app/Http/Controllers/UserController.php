<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\UserRequest;
use App\Models\Access;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HelperModel;
    public function signIn()
    {
        $loginField = filter_var(request('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            'password' => request('password'),
            $loginField => request('login'),
        ];
        $user = User::where($loginField, request('login'))->first();
        if (!$user) {
            return response()->json(['Usuário não encontrado.'], 404);
        }

        if (!$user->active) {
            return response()->json(['Usuário inativo.'], 403);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['Login e senha inválidos.'], 401);
        }
        self::createAccess();
        return response()->json($token, 200);
    }

    public function signUp(UserRequest $request)
    {
        if (self::createRecord(User::class, $request->all())) {
            return response()->json(['message' => "Cadastro realizado com sucesso, foi enviado um link de ativação para o e-mail {$request->email}, o link expira em: " . now()->addDay(1)->format('d/m/y H:i:s')], 201);
        }
    }

    private static function createAccess()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $data = json_decode(file_get_contents("http://ipinfo.io/json"), true);
        self::createRecord(Access::class, [
            'city' => $data['city'] . ' ' . $data['region'] . ' ' . $data['country'],
            'ip_address' => $data['ip'],
            'platform' => $agent->platform(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser())
        ]);
    }

    public function activateUser(Request $request)
    {
        $user = User::whereEmailAndToken($request->email, $request->token)->first();
        if (!$user) {
            return response()->json(['message' => 'Link indisponível'], 404);
        }

        if ($user->token_expires_at < now()) {
            return response()->json(['message' => 'Link expirado'], 400);
        }
        if (self::updateRecord(User::class, [], ['id' => $user->id])) {
            return response()->json(['message' => 'Usuário ativado com sucesso.'], 200);
        }
    }

    public function signOut()
    {
        return 'SignOut';
    }
}

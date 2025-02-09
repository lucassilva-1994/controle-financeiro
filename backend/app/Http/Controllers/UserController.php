<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\ForgotPassword;
use App\Models\{Access,User};
use App\Traits\ModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use ModelTrait;
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
        return response()->json([
            'token' => $token
        ], 200);
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
        ], false);
    }

    public function activateAccount(Request $request)
    {
        $user = User::whereEmailAndToken($request->email, $request->token)->first();
        if (!$user) {
            return response()->json(['message' => 'Link indisponível'], 400);
        }

        if ($user->token_expires_at < now()) {
            return response()->json(['message' => 'Link expirado'], 400);
        }
        if (self::updateRecord(User::class, [], ['id' => $user->id])) {
            return response()->json(['message' => 'Usuário ativado com sucesso.'], 200);
        }
    }

    public function restorePassword(UserRequest $request){
        if(self::updateRecord(User::class, $request->only('password'),['id'=> auth()->user()->id])){
            return response()->json([
                'message' => 'Senha atualizada com sucesso.'
            ], 200);
        }
        return response()->json([
            'message' => 'Falha ao atualizar senha'
        ], 400);
    }

    public function forgotPassword(UserRequest $request){
        $user = User::where('email',$request->email)->first();
        $request['password'] = generateRandomPassword(30);
        $user->password = $request['password'];
        Mail::to($user->email)->send(new ForgotPassword($user));
        if(self::updateRecord(User::class, $request->only('password'),['email' => $user->email])){
            return response()->json([
                'message' => 'Uma nova senha foi enviada para o seu email. Por favor, verifique seu e-mail.'
            ], 200);
        }
        return response()->json([
            'message' => 'Falha ao solicitar recuperação de senha.'
        ], 400);
    }

    public function validateToken(){
        return response()->json([
            'valid' => auth()->check() ? 1 : 0
        ]);
    }

    public function profile()
    {
        return request()->user()->loadCount(['accesses', 'categories', 'payments', 'financialRecords','suppliersAndCustommers']);
    }

    public function signOut(){
        auth()->logout(true);
    }
}

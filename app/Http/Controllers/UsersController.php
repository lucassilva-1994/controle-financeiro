<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller {
    public function __construct(User $user) {
        $this->user = $user;
    }
    
    public function index() {
        return view("user.index");
    }

    public function auth(Request $request) {
        $request->validate(
                ['user' => 'required','password' => 'required'],
                ['user.required' => 'Usuário é obrigatório.','password.required' => 'Senha é obrigatório.']);
        //Criando Array para Autenticação
        $credentials = ['user' => $request->user,'password' => $request->password,'status' => 'ATIVO'];
        if (Auth::attempt($credentials)) {
            $user = DB::table("users")->where("user", $request->user)->first();
            session()->put(["user" => $user->user, "id_user" => $user->id_user]);
            return to_route("index.release");
        }
        return redirect()->back()->with(["error"=>"Usuário não autenticado, "
                        . "verifique se o usuário e senha estão corretos ou se sua conta está ativa!",'user'=>$request->user]);
    }

    public function new() {
        return view("user.new");
    }
    
    public function create(UserRequest $request) {
        $userData = $request->except(['_token', 'ccpassword']);
        $userData['password'] = bcrypt($userData['cpassword']);
        $userData["token"] = $request->_token;
        $user = $this->user->create($userData);
        if ($user) {
            $infoMessage = ['nome' => $request->name,'user' => $request->user,'token' => $request->_token];
            Mail::send('mail.validate', $infoMessage, function($m) use ($request) {
                $m->from(env("MAIL_USERNAME"), env("MAIL_FROM_NAME"));
                $m->to($request['email']);
                $m->subject("Controle financeiro online - Cadastro");
            });
            return to_route('index.user')->with('success', 'Usuário cadastrado com sucesso, verifica seu e-mail para validar sua conta.');
        }
        return to_route('index.user')->with('error', 'Falha ao tentar criar conta.');
    }

    public function validateUser($token) {
        $user = User::where('token', $token)->where("status", "INATIVO")->first();
        if ($user) {
            $user->status = 'ATIVO';$user->token = "";$user->save();
            return to_route('index.user')->with('success', 'Sua conta foi ativada com sucesso!');
        }
        return to_route('index.user')->with('error', 'Link não disponível.');
    }
    
    public function resetPassword() {
        return view('user.resetpassword');
    }

    public function updateToken(Request $request) {
        $user = User::where('email', $request->email)->first();
        $token = $request->_token;
        if ($user) {
            $user->token = $token;$user->save();
            $message = ['nome' => $user->name,'user' => $user->user,'token' => $user->token];
            Mail::send('mail.resetpassword', $message, function($m) use ($request) {
                $m->from(env("MAIL_USERNAME"), env("MAIL_FROM_NAME"));
                $m->to($request['email']);
                $m->subject("Controle financeiro online - Redefinir senha");
            });
            return to_route('index.user')->with('success', 'Sua solicitação foi enviada, acesse seu email para continuar.');
        }
        return to_route('resetpassword.user')->with('error', 'Email não cadastrado.');
    }

    public function newPassword($token) {
        return view('user.newpassword', compact('token'));
    }

    public function updatePassword(ResetPassword $request) {
        $user = User::where('token', $request->token)->first();
        if ($user) {
            $user->token = '';$user->password = bcrypt($request->cpassword);$user->save();
            return to_route('index.user')->with('success', 'Senha alterada com sucesso.');
        }
        return to_route('index.user')->with('error', 'Falha ao alterar senha.');
    }

    public function logout() {
        session()->forget(['id_user', 'user']);
        return to_route('index.user');
    }
}

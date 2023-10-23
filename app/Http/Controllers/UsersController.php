<?php

namespace App\Http\Controllers;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller {

    public function signIn() {
        if(Auth::user()){
            return to_route('show.release');
        }
        return view("user.signin");
    }

    public function auth(AuthRequest $request) {
        $credentials = $request->only(["email","password"]);
        if (Auth::attempt($credentials)) {
            $user = User::where('email',$request->email)->first();
            return to_route("new.release");
        }
        return redirect()->back()->with('error','Falha na autenticação');
    }

    public function signUp() {
        return view("user.signup");
    }

    public function create(UserRequest $request) {
        if(User::createUser($request->only(['name','email','user'])))
            return redirect()->back()->with('success','Usuário cadastrado com sucesso.');
        return redirect()->back()->with('error','Falha ao registrar usuário.');
    }

    private function createOrUpdatePasword(string $token = null){
        $findToken = User::where('token',$token)->first();
        return view('user.password',compact('findToken'));
    }

    public function createPassword(string $token = null){
        return $this->createOrUpdatePasword($token);
    }

    public function updatePassword(string $token = null){
        return $this->createOrUpdatePasword($token);
    }

    public function savePassword(PasswordRequest $request){
        if(User::createOrUpdatePasword($request->only(['cpassword','token'])))
            return to_route('user.signin')->with('success', "Senha configurada com sucesso.");
        return redirect()->back()->with('error','Falha ao configurar senha.');
    }

    public function resetPassword(Request $request){
        $request->validate(
            ['remail' => 'required|exists:users,email'],
            ['remail.required' => 'Email é obrigatório','remail.exists' => 'Email não encontrado.']
        );
        if(User::resetPassword($request->only('remail')))
            return redirect()->back()->with('success', 'Foi enviado um e-mail para alterar sua senha.');
        return redirect()->back()->with('error','Falha ao solicitar redefinição de senha, tente novamente mais tarde.');
    }

    public function signOut() {
        Auth::logout();
        return to_route('user.signin');
    }
}

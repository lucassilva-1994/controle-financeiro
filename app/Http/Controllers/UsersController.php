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

    public function signIn() {
        return view("user.signin");
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

    public function signUp() {
        return view("user.signup");
    }

    public function create(UserRequest $request) {
        return User::createUser($request->only(['name','email','user']));
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

    public function savePassword(Request $request){
        return User::createOrUpdatePasword($request->only(['cpassword','token']));
    }

    public function resetPassword(Request $request){
        $request->validate(
            ['remail' => 'required|exists:users,email'],
            ['remail.required' => 'Email é obrigatório','remail.exists' => 'Email não encontrado.']
        );
        return User::resetPassword($request->only('remail'));
    }

    public function logout() {
        session()->forget(['id_user', 'user']);
        return to_route('index.user');
    }
}

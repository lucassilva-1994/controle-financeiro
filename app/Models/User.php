<?php
namespace App\Models;

use App\Mail\SendWelcome;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    protected $fillable = ['id','sequence','name','email','user','password','token','expires_token'];
    protected $table = "users";
    protected $keyType = 'string';
    public $incrementing = false;

    public static function createUser(array $data){
        $data['name'] = $data['name'];
        $data['email'] = $data['email'];
        $data['user'] = $data['user'];
        $data['password'] = '123';
        $data['token'] = HelperModel::setUuid();
        $data['expires_token'] = date('Y-m-d H:i:s',strtotime('+24 hours'));
        $user = HelperModel::setData($data,User::class);
        if($user){
            Mail::send(new SendWelcome($user));
            Category::createUserCategory($user->id);
            return redirect()->back()->with("success","Usuário cadastrado com sucesso.");
        }
    }

    public static function createOrUpdatePasword(array $data){
        HelperModel::updateData([
            'password' => bcrypt($data['cpassword']),
            'expires_token' => null,
            'token' => null,
            'is_active' => 1
        ],User::class,['token' => $data['token']]);
        return to_route('index.user')->with('success',"Senha configurada com sucesso.");
    }

    public function categories(){
        return $this->hasMany(Category::class,'id','user_id');
    }
}

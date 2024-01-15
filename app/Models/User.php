<?php

namespace App\Models;

use App\Mail\SendResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\Model as ModelTrait;

class User extends Authenticatable
{
    use ModelTrait;
    protected $fillable = ['id', 'sequence', 'name', 'email', 'username', 'password', 'token', 'expires_token','created_at','updated_at'];
    protected $table = 'users';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    
    public static function createUser(array $data)
    {
        $data['token'] = self::setUuid();
        $data['expires_token'] = now()->add('+24 hours');
        if (self::setData($data, User::class)) {
            return true;
        }
        return false;
    }

    public static function createOrUpdatePasword(array $data)
    {
        self::updateData([
            'password' => bcrypt($data['cpassword']),
            'expires_token' => null,
            'token' => null,
            'active' => 1
        ], User::class, ['token' => $data['token']]);
        return true;
    }

    public static function resetPassword(array $data)
    {
        self::updateData([
            'password' => Str::random(12),
            'expires_token' => now()->add('+24 hours'),
            'token' => self::setUuid(),
            'active' => 0
        ], User::class, ['email' => $data['remail']]);
        $user = User::where('email', $data['remail'])->first();
        Mail::queue(new SendResetPassword($user));
        return true;
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    public function creditorsClients(){
        return $this->hasMany(CreditorClient::class);
    }
}

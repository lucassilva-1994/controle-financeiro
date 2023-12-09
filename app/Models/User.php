<?php

namespace App\Models;

use App\Mail\SendResetPassword;
use App\Mail\SendWelcome;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $fillable = ['id', 'sequence', 'name', 'email', 'user', 'password', 'token', 'expires_token','created_at','updated_at'];
    protected $table = 'users';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public static function createUser(array $data)
    {
        $data['token'] = HelperModel::setUuid();
        $data['expires_token'] = now()->add('+24 hours');
        $user = HelperModel::setData($data, User::class);
        if ($user) {
            Mail::queue(new SendWelcome($user));
            Category::createUserCategory($user->id);
            Payment::createUserPayment($user->id);
            return true;
        }
        return false;
    }

    public static function createOrUpdatePasword(array $data)
    {
        HelperModel::updateData([
            'password' => bcrypt($data['cpassword']),
            'expires_token' => null,
            'token' => null,
            'is_active' => 1
        ], User::class, ['token' => $data['token']]);
        return true;
    }

    public static function resetPassword(array $data)
    {
        HelperModel::updateData([
            'password' => Str::random(12),
            'expires_token' => now()->add('+24 hours'),
            'token' => HelperModel::setUuid(),
            'is_active' => 0
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
}

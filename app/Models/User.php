<?php

namespace App\Models;

use App\Mail\SendResetPassword;
use App\Mail\SendWelcome;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    protected $fillable = ['id', 'sequence', 'name', 'email', 'user', 'password', 'token', 'expires_token'];
    protected $table = "users";
    protected $keyType = 'string';
    public $incrementing = false;

    public static function createUser(array $data)
    {
        $data['token'] = HelperModel::setUuid();
        $data['expires_token'] = self::expiresDate();
        $user = HelperModel::setData($data, User::class);
        if ($user) {
            Mail::queue(new SendWelcome($user));
            Category::createUserCategory($user->id);
            Payment::createUserPayment($user->id);
            return true;
        }
        return false;
    }

    private static function expiresDate()
    {
        return date('Y-m-d H:i:s', strtotime('+24 hours'));
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
            'password' => '',
            'expires_token' => self::expiresDate(),
            'token' => HelperModel::setUuid(),
            'is_active' => 0
        ], User::class, ['email' => $data['remail']]);
        $user = User::where('email', $data['remail'])->first();
        Mail::queue(new SendResetPassword($user));
        return true;
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'user_id');
    }

    public function releases()
    {
        return $this->hasMany(Release::class, 'id', 'user_id');
    }

    public function accesses()
    {
        return $this->hasMany(Access::class, 'id', 'user_id');
    }
}

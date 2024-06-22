<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','email','username','password','photo','token','active','token_expires_at','created_at','updated_at'];
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'user_since' => date('d/m/Y H:i:s', strtotime($this->created_at))
        ];
    }
}
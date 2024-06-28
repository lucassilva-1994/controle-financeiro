<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','email','username','password','photo','token','active','token_expires_at','created_at','updated_at'];
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['password','sequence','id','token','token_expires_at','created_at','updated_at'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function accesses():HasMany{
        return $this->hasMany(Access::class);
    }

    public function getJWTCustomClaims()
    {
        $latestAccess = $this->accesses()->orderByDesc('sequence')->first();
        return [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'member_since' => formatBrazilianDate($this->created_at),
            'last_login_time' =>  $latestAccess ? formatBrazilianDate($latestAccess->created_at) : 'Primeiro acesso',
            'last_login_locale' => $latestAccess->city ??  'Primeiro acesso',
            'last_updated_at' => $this->updated_at ? formatBrazilianDate($this->updated_at) : 'Nenhuma alteração realizada',
        ];
    }
}
<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'users';
    protected $fillable = ['id', 'sequence', 'name', 'email', 'username', 'password', 'token', 'expires_token', 'created_at', 'updated_at'];
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['password'];

    public function categories():HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function payments():HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function releases():HasMany
    {
        return $this->hasMany(Release::class);
    }

    public function clientsAndCreditors():HasMany
    {
        return $this->hasMany(ClientCreditor::class);
    }
}

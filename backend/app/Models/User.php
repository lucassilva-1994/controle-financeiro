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
    protected $keyType = 'string';
    protected $hidden = ['password','sequence','id','token','token_expires_at'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getPhotoAttribute($value)
    {
        return $value ? url(env('APP_URL_FILES', 'photos/') . '/' . $value) : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? formatBrazilianDate($value) : 'Sem alteração';
    }

    public function getCreatedAtAttribute($value)
    {
        return formatBrazilianDate($value);
    }

    public function accesses():HasMany{
        return $this->hasMany(Access::class);
    }

    public function categories():HasMany{
        return $this->hasMany(Category::class);
    }

    public function payments(): HasMany{
        return $this->hasMany(Payment::class);
    }

    public function financialRecords(){
        return $this->hasMany(FinancialRecord::class);
    }

    public function suppliersAndCustommers(): HasMany{
        return $this->hasMany(SupplierAndCustomer::class);
    }

    public function getJWTCustomClaims()
    {
        $latestAccess = $this->accesses()->orderByDesc('sequence')->first();
        return [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'member_since' => $this->created_at,
            'last_login_time' =>  $latestAccess ? formatBrazilianDate($latestAccess->created_at) : 'Primeiro acesso',
            'last_login_locale' => $latestAccess->city ??  'Primeiro acesso'
        ];
    }
}
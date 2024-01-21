<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientCreditor extends Model
{
    protected $table = 'clients_creditors';
    protected $fillable = ['id','sequence','name','type','user_id','created_at','updated_at'];
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }


    public function releases():HasMany{
        return $this->hasMany(Release::class,'creditorsclients_id','id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}

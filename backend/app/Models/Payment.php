<?php

namespace App\Models;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['id','sequence','user_id','name','calculate','created_at','updated_at'];
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    // public function getCreatedAtAttribute(){
    //     return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    // }

    // public function getUpdatedAtAttribute(){
    //     return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    // }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function releases():HasMany{
        return $this->hasMany(Release::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}

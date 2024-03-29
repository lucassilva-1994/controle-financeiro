<?php

namespace App\Models;

use App\Helpers\HelperModel;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HelperModel;
    protected $table = 'categories';
    protected $fillable = ['id', 'sequence', 'name', 'type', 'user_id','created_at','updated_at'];
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function releases(){
        return $this->hasMany(Release::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}

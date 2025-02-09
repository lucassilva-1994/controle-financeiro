<?php

namespace App\Models;

use App\Models\Scopes\{UserScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, Relation};

#[ScopedBy([UserScope::class])]
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id','sequence','name','type','description','deleted','created_at','updated_at','user_id'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function financialRecords(): HasMany{
        return $this->hasMany(FinancialRecord::class,'category_id','id');
    }

    public function logs(){
        return $this->morphMany(RecordLog::class, 'entity');
    }
}

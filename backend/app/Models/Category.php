<?php

namespace App\Models;

use App\Models\Scopes\{NotDeletedScope, UserScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

#[ScopedBy([UserScope::class, NotDeletedScope::class])]
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id','sequence','name','type','description','deleted','created_at','updated_at','user_id'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class)->select(['id','name','username','email']);
    }

    public function financialRecords(): BelongsToMany{
        return $this->belongsToMany(FinancialRecord::class,'category_financial_record','category_id','financial_record_id');
    }
}

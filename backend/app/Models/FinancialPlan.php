<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

#[ScopedBy([UserScope::class])]
class FinancialPlan extends Model
{
    protected $table = 'financial_plans';
    protected $fillable = ['id','sequence','name','description','plan_type','created_at','updated_at','user_id'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function financialPlanItems(): HasMany{
        return $this->hasMany(FinancialPlanItem::class,'financial_plan_id','id');
    }
}

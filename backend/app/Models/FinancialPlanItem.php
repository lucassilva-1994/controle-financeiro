<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialPlanItem extends Model
{
    protected $table = 'financial_plans_items';
    protected $fillable = ['id','sequence','checked','name','amount','qtd','unit','due_date','created_at','updated_at','financial_plan_id','user_id'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'checked' => 'boolean'
    ];
    
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function financialPlan():BelongsTo{
        return $this->belongsTo(FinancialPlan::class,'financial_plan_id','id');
    }
}

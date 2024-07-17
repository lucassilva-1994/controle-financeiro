<?php

namespace App\Models;

use App\Models\Scopes\{NotDeletedScope, UserScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, HasOne};

#[ScopedBy([UserScope::class, NotDeletedScope::class])]
class FinancialRecord extends Model
{
    protected $table = 'financial_records';
    protected $fillable = [
        'id', 'sequence', 'description', 'amount', 'financial_record_date', 'financial_record_due_date',
        'paid', 'financial_record_type', 'deleted', 'installment_number', 'installment_total', 'created_at', 
        'updated_at', 'user_id', 'payment_id', 'category_id', 'supplier_customer_id','details'
    ];
    protected $primarykey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $hidden = ['user_id','sequence','deleted'];

    public function payment(): BelongsTo{
        return $this->belongsTo(Payment::class, 'payment_id')->select(['id','name']);
    }

    public function category(): HasOne{
        return $this->hasOne(Category::class,'id','category_id')->select(['id','name']);
    }

    public function supplierAndCustomer(): BelongsTo{
        return $this->belongsTo(SupplierAndCustomer::class, 'supplier_customer_id')->select(['id','name']);
    }

    public function files():HasMany{
        return $this->hasMany(File::class,'financial_record_id','id');
    }
}

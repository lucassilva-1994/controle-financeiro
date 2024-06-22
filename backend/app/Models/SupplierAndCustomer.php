<?php

namespace App\Models;

use App\Models\Scopes\{NotDeletedScope, UserScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

#[ScopedBy([UserScope::class, NotDeletedScope::class])]
class SupplierAndCustomer extends Model
{
    protected $table = 'suppliers_and_customers';
    protected $fillable = ['id','sequence','name','type','email','phone','deleted','created_at','updated_at','user_id'];
    protected $primaryKey = 'id';
    public $incremeting = false;
    public $timestamps = false;

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function financialRecords(): HasMany{
        return $this->hasMany(FinancialRecord::class);
    }
}

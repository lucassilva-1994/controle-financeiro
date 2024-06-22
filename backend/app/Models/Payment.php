<?php

namespace App\Models;

use App\Models\Scopes\{NotDeletedScope, UserScope};
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

#[ScopedBy([UserScope::class, NotDeletedScope::class])]
class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['id','sequence','name','type','description','is_calculable','deleted','created_at','updated_at','user_id'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps;

    protected $casts = [
        'is_calculable' => 'boolean',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function financialRecords(): HasMany{
        return $this->hasMany(FinancialRecord::class);
    }
}

<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ScopedBy([UserScope::class])]
class RecordLog extends Model
{
    protected $table = 'record_logs';
    protected $fillable = [
        'id','sequence','entity_type','entity_id','old_values','current_values', 'content',
        'ip','action','executed_by','executed_at'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $visible = ['id','current_values','old_values'];
    protected $casts = [
        'current_values' => 'array',
        'old_values' => 'array'
    ];

    public function entity(): MorphTo{
        return $this->morphTo();
    }
}

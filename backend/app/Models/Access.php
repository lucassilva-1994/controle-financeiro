<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([UserScope::class])]
class Access extends Model
{
    protected $table = 'accesses';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'sequence', 'ip_address', 'city', 'browser', 'platform', 'created_at', 'user_id'];
    public $incrementing = false;
    public $timestamps = false;
}

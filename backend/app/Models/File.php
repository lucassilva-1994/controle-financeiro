<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $fillable = ['id','sequence','name','path','user_id','financial_record_id','created_at'];
    public $incrementing = false;
    public $timestamps = false;

    public function financialRecord(): BelongsTo{
        return $this->belongsTo(FinancialRecord::class);
    }
}

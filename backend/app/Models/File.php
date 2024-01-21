<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table= 'files';
    protected $fillable = ['id','sequence','name','path','release_id','created_at'];
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public function Release(){
        return $this->belongsTo(Release::class);
    }
}

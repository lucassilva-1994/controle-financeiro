<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = ['old_values','new_values','action','created_at','user_id'];
    public $timestamps = false;
}

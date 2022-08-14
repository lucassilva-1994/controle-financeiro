<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function release(){
        return $this->belongsTo(Release::class);
    }
}

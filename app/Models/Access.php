<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{

    protected $fillable = ["id","sequence","ip_address","user_id",'created_at'];
    protected $table = "accesses";
    public $timestamps = false;

    public static function createAccess(string $user_id,  string $ip){
        $data['ip_address'] = $ip;
        $data['user_id'] = $user_id;
        HelperModel::setData($data,Access::class);
    }

    public function users(){
        return $this->belongsTo(User::class,"user_id","id");
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table= 'files';
    protected $fillable = ['id','sequence','name','path','user_id','release_id','created_at','updated_at'];
    public $timestamps = false;
    protected $keyType = 'string';

    public static function createFiles(array $data, string $release_id, string $user_id, $file){
        $email = auth()->user()->email;
        $data['user_id'] = $user_id;
        $data['release_id'] = $release_id;
        $data['name'] = $file->getClientOriginalName();
        $data['path'] = $file->store("releases/$email/$release_id");
        HelperModel::setData($data,File::class);
    }

    public function Release(){
        return $this->belongsTo(Release::class,'release_id','id');
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

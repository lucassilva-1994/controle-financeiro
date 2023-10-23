<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    protected $table= "files";
    protected $fillable = ['id','sequence','name','path','user_id','release_id'];

    public static function createFiles(array $data, string $release_id, string $user_id, $file){
        $data['user_id'] = $user_id;
        $data['release_id'] = $release_id;
        $data['name'] = $file->getClientOriginalName();
        $data['path'] = $file->store("releases/$user_id/$release_id");
        HelperModel::setData($data,File::class);
    }

    public function Release(){
        return $this->belongsTo(Release::class,'release_id','id');
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

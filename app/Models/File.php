<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Model as ModelTrait;

class File extends Model
{
    use ModelTrait;
    protected $table= 'files';
    protected $fillable = ['id','sequence','name','path','user_id','release_id','created_at'];
    public $timestamps = false;
    protected $keyType = 'string';

    public static function createFiles(string $release_id, string $user_id, $file){
        $email = auth()->user()->email;
        $data['user_id'] = $user_id;
        $data['release_id'] = $release_id;
        $data['name'] = $file->getClientOriginalName();
        $data['path'] = $file->store("releases/$email/$release_id");
        self::setData($data,File::class);
    }

    public function Release(){
        return $this->belongsTo(Release::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}

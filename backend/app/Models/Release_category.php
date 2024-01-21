<?php

namespace App\Models;

use App\Helpers\HelperModel;
use Illuminate\Database\Eloquent\Model;

class Release_category extends Model
{
    use HelperModel;
    protected $table = "releases_categories";
    protected $fillable = ['sequence','release_id','category_id', 'created_at'];
    protected $keyType = "string";
    public $timestamps = false;


    public static function createReleaseCategory(string $release_id, string $category_id){
        $data['release_id'] = $release_id;
        $data['category_id'] = $category_id;
        if(!Release_category::where(['category_id'=>$category_id, 'release_id'=>$release_id])->first()){
            HelperModel::setData($data,Release_category::class);
        }
    }
}

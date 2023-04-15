<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ["id","sequence","name","type","user_id"];
    protected $table = "categories";
    protected $keyType = 'string';
    public $incrementing = false;

    public static function createCategory(array $data, string $user_id){
        $data['user_id'] = $user_id;
        HelperModel::setData($data,Category::class);
    }

    public static function createUserCategory(string $user_id){
        $categories = Category_default::get();
        foreach($categories as $category){
            $data['user_id'] = $user_id;
            $data['name'] = $category->name;
            $data['type'] = $category->type;
            HelperModel::setData($data,Category::class);
        }
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}

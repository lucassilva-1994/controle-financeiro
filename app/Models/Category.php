<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ["id", "sequence", "name", "type", "user_id"];
    protected $table = "categories";
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtAttribute()
    {
        return date("d/m/Y H:i:s", strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date("d/m/Y H:i:s", strtotime($this->attributes['updated_at']));
    }

    public static function createOrUpdate(array $data)
    {
        if (!isset($data['id'])) {
            HelperModel::setData($data, Category::class);
            return true;
        }
        HelperModel::updateData(
            ['name' => $data['name'], 'type' => $data['type']],
            Category::class,
            ['id' => $data['id']]
        );
        return true;
    }

    public static function createUserCategory(string $user_id)
    {
        $categories = Category_default::get();
        foreach ($categories as $category) {
            $data['user_id'] = $user_id;
            $data['name'] = $category->name;
            $data['type'] = $category->type;
            HelperModel::setData($data, Category::class);
        }
    }

    public static function forDelete(string $id)
    {
        self::whereId($id)->delete();
        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function releases(){
        return $this->hasMany(Release::class,'category_id','id');
    }
}

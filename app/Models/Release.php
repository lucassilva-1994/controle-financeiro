<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Release extends Model {

    protected $table = "releases";
    protected $fillable = [
        'id_release',
        'description',
        'details',
        'value',
        'date',
        'type',
        'user_id',
        'category_id',
        'payment'
    ];
    protected $primarykey = "id_release";
    public $timestamps = true;

    public function setValueAttribute($value) {
        $value = str_replace(['R$ ', ".", ','], ["", "", "."], $value);
        $value = number_format("" . $value, 2, ".", "");
        $this->attributes['value'] = $value;
    }

    public function getValueAttribute() {
        return number_format($this->attributes['value'], 2, ",", ".");
    }

    public static function createOrUpdate(array $input): void {
        $release = new Release($input);
        $input = $release->attributes;
        if (isset($input["id_release"])) {
            $release->where("id_release", $input["id_release"])->update($input);
        } else {
            $release->save();
        }
    }

    public static function removeOrRestore($id_release, $status){        
        Release::where("id_release",$id_release)->update(["status"=>$status]);
    }

    public function category() {
        return $this->hasOne(Category::class, "id_category", "category_id");
    }

    protected static function booted() {
        self::addGlobalScope('session_user', function(Builder $queryBuilder) {
            $queryBuilder->where(['user_id' => session()->get('id_user')])->orderByDesc('id_release');
        });
    }
}

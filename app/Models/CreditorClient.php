<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CreditorClient extends Model
{
    protected $fillable = ['id','sequence','name','type','user_id'];
    protected $table = "creditorsclients";
    protected $keyType = 'string';
    public $incrementing = false;
    protected $with = ['releases'];

    public function getCreatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public static function createOrUpdate(array $data){
        if(!isset($data['id'])){
            HelperModel::setData($data,self::class);
            return true;
        }
        HelperModel::updateData($data,self::class,['id' => $data['id']]);
        return true;
    }

    public static function forDelete(string $id){
        self::whereId($id)->delete();
        return true;
    }

    public function releases(){
        return $this->hasMany(Release::class,'creditorsclients_id','id');
    }
}

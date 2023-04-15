<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class HelperModel extends Model
{
    public static function setData(array $data, $model){
        $data['id'] = self::setUuid();
        $data['sequence'] = self::setSequence($model);
        $data['created_at'] = self::setDate();
        $data['updated_at'] = self::setDate();
        return $model::create($data);
    }

    public static function updateData(array $data, $model, array $where){
        $data['updated_at'] = self::setDate();
        return $model::where($where)->update($data);
    }

    public static function setUuid(){
        return Uuid::uuid4();
    }

    private static function setSequence($model){
        $result = $model::latest('sequence')->first();
        return $result ? $result->sequence + 1 : 1;
    }

    public static function setDate(){
        return date("Y-m-d H:i:s");
    }
}

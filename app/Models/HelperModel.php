<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class HelperModel extends Model
{
    public static function setData(array $data, $model){
            $data['id'] = self::setUuid();
            $data['sequence'] = self::setSequence($model);
            $data['created_at'] = now();
            if(isset($data['password'])){
                $data['password'] = bcrypt($data['password']);
            }
            return $model::create($data);
    }

    public static function updateData(array $data, $model, array $where){
        $data['updated_at'] = now();
        return $model::where($where)->update($data);
    }

    public static function setUuid(){
        return Uuid::uuid4();
    }

    private static function setSequence($model){
        $result = $model::latest('sequence')->first();
        return $result ? $result->sequence += 1 : 1;
    }
}

<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;

trait Model
{
    public static function setData(array $data, $model)
    {
        $data['id'] = self::setUuid();
        $data['sequence'] = self::setSequence($model);
        $data['created_at'] = now();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return $model::updateOrCreate($data);
    }

    public static function updateData(array $data, $model, array $where)
    {
        $data['updated_at'] = now();
        return $model::updateOrCreate($where,$data);
    }

    public static function setUuid()
    {
        return Uuid::uuid7(now());
    }

    private static function setSequence($model)
    {
        $result = $model::withoutGlobalScope('users')->latest('sequence')->first();
        return $result ? $result->sequence += 1 : 1;
    }
}

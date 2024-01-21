<?php

namespace App\Helpers;

use App\Models\Scopes\UserScope;
use Ramsey\Uuid\Uuid;

trait HelperModel
{
    public static function setData(array $data, $model)
    {
        $data['id'] = self::setUuid();
        $data['sequence'] = self::setSequence($model);
        $data['created_at'] = now();
        if(in_array('user_id', (new $model)->getFillable()) && auth()->check()) {
            $data['user_id'] = auth()->user()->id;
        }
        if(in_array('token', (new $model)->getFillable()) && in_array('expires_token', (new $model)->getFillable()) ) {
            $data['token'] = self::setUuid();
            $data['expires_token'] =  now()->add('+24 hours');
        }
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return $model::updateOrCreate($data);
    }

    public static function updateData(array $data, $model, array $where)
    {
        $data['updated_at'] = now();
        return $model::updateOrCreate($where, $data);
    }

    public static function setUuid()
    {
        return Uuid::uuid7(now());
    }

    private static function setSequence($model)
    {
        $result = $model::withoutGlobalScope(new UserScope)->latest('sequence')->first();
        return $result ? $result->sequence += 1 : 1;
    }
}

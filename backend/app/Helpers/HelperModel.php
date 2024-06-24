<?php
namespace App\Helpers;
use Ramsey\Uuid\Uuid;
trait HelperModel
{
    use HelperMessage;
    public static function createRecord(string $model, array $data)
    {   
        $fillable = (new $model)->getFillable();
        $data = array_intersect_key($data, array_flip($fillable));
        $data['id'] = self::generateUuid();
        $data['sequence'] = self::setSequenceNumber($model);
        $data['created_at'] = now();
        if (in_array('token', $fillable)) {
            $data['token'] = base64_encode(str()->random(75));
        }
        if (in_array('token_expires_at', $fillable)) {
            $data['token_expires_at'] = now()->addDay(1);
        }
        if (in_array('password', $fillable)) {
            $data['password'] = bcrypt($data['password']);
        }
        if (in_array('user_id', $fillable) && auth()->check()) {
            $data['user_id'] = auth()->user()->id;
        }
        if (isset($data['name']) && auth()->check()) {
            $data['name'] = self::ensureUniqueValue('name',$data['name'], $model);
        }
        
        return request()->routeIs('signup') ? $model::create($data) : (function() use ($model, $data) {
            try {
                $model::create($data);
                return self::success();
            } catch (\Throwable $th) {
                return $th->getMessage();
                return self::error();
            }
        })();
    }

    public static function updateRecord(string $model, array $data, array $where){
        $fillable = (new $model)->getFillable();
        $data = array_intersect_key($data, array_flip($fillable));
        if (in_array('token_expires_at', $fillable)) {
            $data['token_expires_at'] = null;
        }
        if (in_array('token', $fillable)) {
            $data['token'] = '';
        }
        if (in_array('active', $fillable)) {
            $data['active'] = 1;
        }
        $data['updated_at'] = now();
        try {
            $model::updateOrCreate($where, $data);
            return self::success();
        } catch (\Throwable $th) {
            return self::error();
        }
    }

    public static function markAsDeleted(string $model, array $where) {
        $data['deleted'] = 1;
        $data['updated_at'] = now();
        return $model::where($where)->update($data);
    }

    public static function setSequenceNumber(string $model) {
        return $model::max('sequence') + 1;
    }

    public static function generateUuid(){
        return Uuid::uuid7(now());
    }

    private static function ensureUniqueValue($field, $value, $model)
    {
        $originalValue = $value;
        $counter = 1;
        while ($model::where($field, $value)->exists()) {
            $value = "{$originalValue} ({$counter})";
            $counter++;
        }
        return $value;
    }
}

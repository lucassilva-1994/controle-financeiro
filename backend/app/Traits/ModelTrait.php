<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
trait ModelTrait
{
    public static function createRecord(string $model, array $data):JsonResponse
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
        if (isset($data['amount'])) {
            $data['amount'] = str_replace(['R$ ', ".", ','], ["", "", "."], $data['amount']);
            $data['amount'] = number_format("" . $data['amount'], 2, ".", "");
            $data['amount'] = $data['amount'];
        }
        try {
            return response()->json([
                'message' => 'Os dados foram cadastrados com sucesso.',
                'data' => $model::updateOrCreate(['id' => $data['id']], $data)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Houve um problema ao cadastrar os dados. Por favor, tente novamente mais tarde.',
                'data' => null
            ], 400);
        }
    }

    public static function updateRecord(string $model, array $data, array $where):JsonResponse{
        if(!$model::where($where)->exists()){
            $data['id'] = $where;
            return self::createRecord($model, $data);
        }
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
        if (in_array('password', $fillable) && array_key_exists('password', $data)) {
            $data['password'] = bcrypt($data['password']);
        }
        if (isset($data['amount'])) {
            $data['amount'] = str_replace(['R$ ', ".", ','], ["", "", "."], $data['amount']);
            $data['amount'] = number_format("" . $data['amount'], 2, ".", "");
            $data['amount'] = $data['amount'];
        }
        $data['updated_at'] = now();
        try {
            return response()->json([
                'message' => 'As alterações foram salvas com sucesso.',
                'data' => $model::updateOrCreate($where, $data)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro durante a atualização. Por favor, tente novamente.',
                'data' => null
            ], 400);
        }
    }

    public static function markAsDeleted(string $model, array $where):JsonResponse {
        $data['deleted'] = 1;
        $data['updated_at'] = now();
        try {
            $model::updateOrCreate($where, $data);
            return response()->json([
                'message' => 'Registro excluído com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível excluir o registro. Por favor, tente novamente.'
            ], 400); 
        }
    }
    

    public static function setSequenceNumber(string $model) :int{
        return $model::max('sequence') + 1;
    }

    public static function generateUuid(){
        return Uuid::uuid7(now());
    }

    private static function ensureUniqueValue($field, $value, $model): string
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

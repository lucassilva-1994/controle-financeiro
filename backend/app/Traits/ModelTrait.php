<?php

namespace App\Traits;

use App\Models\RecordLog;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

trait ModelTrait
{
    public static function createRecord(string $model, array $data, $createLog = true): JsonResponse
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
            $data['name'] = self::ensureUniqueValue('name', $data['name'], $model);
        }
        if (isset($data['amount'])) {
            $data['amount'] = str_replace(['R$ ', ".", ','], ["", "", "."], $data['amount']);
            $data['amount'] = number_format("" . $data['amount'], 2, ".", "");
            $data['amount'] = $data['amount'];
        }
        if (isset($data['qtd'])) {
            $data['qtd'] = str_replace([",", "."], ["", "."], $data['qtd']);
            $data['qtd'] = number_format((float) $data['qtd'], 2, ".", "");
        }
        try {
            $record = $model::updateOrCreate(['id' => $data['id']], $data);
            //For logs
            $log['entity_type'] = $model;
            $log['entity_id'] = $data['id'];
            $log['current_values'] = $record;
            $log['action'] = 'CREATE';
            $log['content'] = 'Registro cadastrado com sucesso.';
            if($createLog){
                self::createLog($log);
            }
            return response()->json([
                'message' => 'Os dados foram cadastrados com sucesso.',
                'data' => $record
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public static function updateRecord(string $model, array $data, array $where): JsonResponse
    {
        $existingRecord = $model::where($where)->first();
        if (!$existingRecord) {
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
        if (isset($data['amount']) && (strpos($data['amount'], ',') !== false || strpos($data['amount'], 'R$') !== false)) {
            $data['amount'] = number_format(str_replace(['R$ ', '.', ','], ['', '', '.'], $data['amount']), 2, '.', '');
        }
        if (isset($data['qtd'])) {
            $data['qtd'] = str_replace([",", " "], ["", ""], $data['qtd']); 
            $data['qtd'] = number_format((float) $data['qtd'], 2, ".", "");
        }
        try {
            $record = $model::updateOrCreate($where, $data);
            $changedValues = $record->getChanges();
            if (!empty($changedValues)) {
                $record->timestamps = false;
                $record->updated_at = now();
                $record->save();
                $oldValues = array_intersect_key($existingRecord->toArray(), $changedValues);
                self::createLog([
                    'entity_type'    => $model,
                    'entity_id'      => $record->id,
                    'old_values'     => $oldValues,
                    'current_values' => $changedValues,
                    'action'         => 'UPDATE',
                    'content'        => 'Registro atualizado com sucesso.'
                ]);
            }
            return response()->json([
                'message' => 'As alterações foram salvas com sucesso.',
                'data' => $record
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public static function deleteRecord(string $model, array $where): JsonResponse{
        $existingRecord = $model::where($where)->first();
        try {
            self::createLog([
                'entity_type'    => $model,
                'entity_id'      => $existingRecord->id,
                'old_values'     => $existingRecord,
                'action'         => 'DELETE',
                'content'        => 'Registro excluído com sucesso.'
            ]);
            $existingRecord->delete();
            return response()->json([
                'message' => 'Registro excluído com sucesso.',
                'data' => null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public static function markAsDeleted(string $model, array $where): JsonResponse
    {
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


    public static function setSequenceNumber(string $model): int
    {
        return $model::max('sequence') + 1;
    }

    public static function generateUuid()
    {
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

    private static function createLog(array $data)
    {
        RecordLog::create([
            'id' => self::generateUuid(),
            'sequence' => self::setSequenceNumber(RecordLog::class),
            'entity_type' => $data['entity_type'],
            'entity_id' => $data['entity_id'],
            'old_values' => $data['old_values'] ?? null,
            'current_values' => $data['current_values'] ?? null,
            'content' => $data['content'],
            'ip' => request()->ip(),
            'action' => $data['action'],
            'executed_by' => auth()->user()->id,
            'executed_at' => now()
        ]);
    }
}

<?php 
namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\{Builder,Model,Scope};
use Illuminate\Support\Facades\Schema;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check()) {
            $tableName = $model->getTable();
            $userId = auth()->user()->id;
            $hasUserId = Schema::hasColumn($tableName, 'user_id');
            $hasExecutedBy = Schema::hasColumn($tableName, 'executed_by');
            if ($hasUserId || $hasExecutedBy) {
                $builder->where(function($query) use ($tableName, $userId, $hasUserId, $hasExecutedBy) {
                    if ($hasUserId) {
                        $query->where("$tableName.user_id", $userId);
                    }
                    if ($hasExecutedBy) {
                        $query->orWhere("$tableName.executed_by", $userId);
                    }
                })
                ->orderByDesc('sequence');
            }
        }
    }
}

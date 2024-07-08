<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if(auth()->check()){
            $tableName = $model->getTable();
            $builder->where("$tableName.user_id",auth()->user()->id)->orderBydesc('sequence');
        }
    }
}

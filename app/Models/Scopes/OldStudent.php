<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class OldStudent implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.s
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where("old", 1)->where("reserve_at",null);
    }
}

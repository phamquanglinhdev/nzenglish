<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cookie;

class OriginInvoiceScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $origin = Cookie::get("origin") ?? 1;
        $builder->whereHas("student", function (Builder $student) use ($origin) {
            $student->where("origin",$origin);
        });
    }
}

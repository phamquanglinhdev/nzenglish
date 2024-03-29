<?php

namespace App\Models;

use App\Models\Scopes\ReserveScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Common
{
    use CrudTrait;
    use HasFactory;

    protected $table = "students";

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new ReserveScope);
    }
}

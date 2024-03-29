<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Models\Scopes\ExtendScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $month
 * @property mixed $start_extend;
 */
class Extend extends Invoice
{
    use CrudTrait;



    protected static function boot()
    {
        parent::fakeBoot(); // TODO: Change the autogenerated stubs
        static::addGlobalScope(new ExtendScope);
    }

    use HasFactory;
}

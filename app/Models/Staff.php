<?php

namespace App\Models;

use App\Models\Scopes\OriginScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Staff extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OriginScope);
    }

    use HasFactory;
    use SoftDeletes;

    protected array $date = ["deleted_at"];

    protected $table = 'users';

}

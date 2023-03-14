<?php

namespace App\Models;

use App\Models\Scopes\OriginScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OriginScope);
    }
    use HasFactory;

    protected $table = 'users';

}

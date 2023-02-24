<?php

namespace App\Models;

use App\Models\Scopes\OldStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Old extends Student
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OldStudent);
    }

    protected $table = "students";

}

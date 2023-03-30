<?php

namespace App\Models;

use App\Models\Scopes\OldStudent;
use App\Models\Scopes\StudentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Old extends Common
{
    use HasFactory;
    use SoftDeletes;

    protected array $date = ["deleted_at"];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OldStudent);
    }

    protected $table = "students";

}

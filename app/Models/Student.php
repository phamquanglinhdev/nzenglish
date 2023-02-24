<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'students';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setDaysAttribute()
    {
        if ($this->attributes["days"] == null) {
            $cycle = (int)$_REQUEST["cycle"];
            $this->attributes["days"] = Carbon::parse($this->start)->diffInDays(Carbon::parse($this->start)->addMonths($cycle));
        }
    }

    public function end()
    {
        $start = $this->start;
        $end = Carbon::create($start);
        return $end->addDays($this->days)->isoFormat("DD-MM-YYYY");
    }

    public function remaining()
    {
        return Carbon::parse($this->end())->diffInDays(Carbon::now());
    }

    public function isWarning()
    {
        return $this->remaining() <= 7;
    }
    public function expired(): bool
    {
        return Carbon::parse($this->end()) < Carbon::create(now());
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

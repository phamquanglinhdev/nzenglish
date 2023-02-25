<?php

namespace App\Models;

use App\Models\Scopes\OriginScope;
use App\Models\Scopes\StudentScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
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

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OriginScope);
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setDaysAttribute()
    {
        if (!isset($this->attributes["days"])) {
            $cycle = (int)$_REQUEST["cycle"];
            $this->attributes["days"] = Carbon::parse($this->start)->diffInDays(Carbon::parse($this->start)->addMonths($cycle));
        }
    }

    public function days()
    {
        return Carbon::parse($this->start)->diffInDays($this->end);
    }

    public function remaining()
    {
        return Carbon::parse($this->end)->diffInDays(Carbon::now());
    }

    public function isWarning()
    {
        return $this->remaining() <= 7;
    }

    public function expired(): bool
    {
        return Carbon::parse($this->end) < Carbon::create(now());
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

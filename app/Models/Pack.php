<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class Pack extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'packs';
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
    public function setPackageAttribute()
    {
        $this->attributes["items"] = $this->name . "(" . $this->value . ")";
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function Invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, "pack_id", "id");
    }

    public function Extends(): HasMany
    {
        return $this->hasMany(Extend::class, "pack_id", "id");
    }

    protected function scopeMonth($query)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $origin = Cookie::get("origin");
        $query->where(function (Builder $builder) use ($origin, $end, $start) {
            $builder->whereHas("invoices", function (Builder $invoices) use ($origin, $end, $start) {
                $invoices
                    ->whereHas("student", function (Builder $student) use ($origin) {
                        $student->where("origin", $origin);
                    })
                    ->where("updated_at", ">=", $start)->where("updated_at", "<=", $end);
            })->orWhereHas("extends", function (Builder $extends) use ($origin, $end, $start) {
                $extends
                    ->whereHas("student", function (Builder $student) use ($origin) {
                        $student->where("origin", $origin);
                    })->where("updated_at", ">=", $start)->where("updated_at", "<=", $end);
            });
        });
    }
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

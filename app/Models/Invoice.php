<?php

namespace App\Models;

use App\Models\Scopes\OriginInvoiceScope;
use App\Models\Scopes\OriginScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OriginInvoiceScope);
    }

    protected static function fakeBoot()
    {
        parent::boot();
    }

    protected function scopeMonth($query)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $query->where("updated_at", ">=", $start)->where("updated_at", "<=", $end);
    }

    protected $table = 'invoices';
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Student()
    {
        return $this->belongsTo(Common::class, "student_id", "id")->withTrashed();
    }

    public function Staff()
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function Pack()
    {
        return $this->belongsTo(Pack::class, "pack_id", "id");
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

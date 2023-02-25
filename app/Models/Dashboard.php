<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    public static function student()
    {
        return Student::all()->count();
    }

    public static function remaining()
    {
        return Student::where('end', "<", Carbon::parse(now())->addDays(7))->where("end", ">=", Carbon::parse(now()))->count();
    }

    public static function expired()
    {
        return Student::where("end", "<", Carbon::parse(now()))->count();
    }

    public static function old()
    {
        return Old::all()->count();
    }

    public static function log()
    {
        return Log::all()->count();
    }

    public static function frequency()
    {
        return "65%";
    }
}

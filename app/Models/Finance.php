<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Finance extends Model
{
    use HasFactory;

    public static function month()
    {
        $month = [];
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $days = CarbonPeriod::create($start, $end);
        foreach ($days as $day) {
            $item = new \stdClass();
            $item->day = $day->isoFormat("DD/MM/YYYY");
            $item->invoice = (int)Invoice::whereDate("created_at", Carbon::parse($day))->sum("value");
            $item->extend = (int)Extend::whereDate("created_at", Carbon::parse($day))->sum("value");
            $item->payment = (int)Payment::whereDate("created_at", Carbon::parse($day))->sum("value");
            $item->total = $item->invoice + $item->extend - $item->payment;
            $month[] = $item;
        }

        return Collection::make($month);

    }
}

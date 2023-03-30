<?php

namespace App\Http\Controllers;

use App\Utils\Analytics;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? null;
        $month = $request->month ?? null;
        if ($year != null && $month != null) {
            $date = Carbon::parse($year . "-" . $month . "-01" . "00:00:00");
            $analytics = Analytics::financeAnalyticByMonth($date);
            $target = $month . "-" . $year;
        } else {
            $analytics = Analytics::financeAnalyticByMonth(now());
            $target = Carbon::parse(now())->isoFormat("MM-YYYY");
        }

        return view("finance.index", ['finances' => $analytics, 'target' => $target]);
    }
}

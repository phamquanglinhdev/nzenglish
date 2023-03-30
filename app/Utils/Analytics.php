<?php

namespace App\Utils;

use App\Models\Extend;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Analytics
{
    public static function financeAnalyticByMonth($time)
    {

        $finance = [];
        $start = Carbon::parse($time)->startOfMonth();
        $end = Carbon::parse($time)->endOfMonth();
        $days = CarbonPeriod::create($start, $end);
        $totalInvoice = 0;
        $totalExtend = 0;
        $totalPayment = 0;
        foreach ($days as $day) {
            $startDay = Carbon::parse($day)->startOfDay();
            $endDay = Carbon::parse($day)->endOfDay();
            $item = new \stdClass();
            $invoice = Invoice::where("updated_at", ">=", $startDay)->where("updated_at", "<=", $endDay)->where("confirm", 1)->sum("value");
            $item->invoice = $invoice;
            $totalInvoice += $invoice;
            $extend = Extend::where("updated_at", ">=", $startDay)->where("created_at", "<=", $endDay)->where("confirm", 1)->sum("value");
            $item->extend = $extend;
            $totalExtend += $extend;
            $payment = Payment::where("updated_at", ">=", $startDay)->where("created_at", "<=", $endDay)->sum("value");
            $item->payment = $payment;
            $totalPayment += $payment;
            if ($invoice != 0 || $extend != 0 || $payment != 0) {
                $finance[$day->isoFormat("DD/MM/YYYY")] = $item;
            }

        }
        $total = new \stdClass();
        $total->invoice = $totalInvoice;
        $total->extend = $totalExtend;
        $total->payment = $totalPayment;
        $finance["totalCol"] = $total;
        return $finance;
    }

}

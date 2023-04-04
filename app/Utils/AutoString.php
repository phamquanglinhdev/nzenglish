<?php

namespace App\Utils;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AutoString
{
    public static function invoiceCode(): string
    {
        $max = DB::table("invoices")->max("id");
        return Str::upper(Str::random(3)) . str_replace(".", "", (($max + 1) / 10000));
    }
}

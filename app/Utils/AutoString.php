<?php

namespace App\Utils;

use App\Models\Invoice;
use Illuminate\Support\Str;

class AutoString
{
    public static function invoiceCode(): string
    {
        return Str::upper(Str::random(3)) . str_replace(".", "", ((Invoice::max("id") + 1) / 10000));
    }
}

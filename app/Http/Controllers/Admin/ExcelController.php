<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FinanceExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function month()
    {
        $currentMonth = Carbon::now()->month . "_" . Carbon::now()->year;
        return Excel::download(new FinanceExport, "Báo_cáo_tháng_$currentMonth.xlsx");
    }

    public function user()
    {
        return Excel::download(new UsersExport, "users.xlsx");
    }
}

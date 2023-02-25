<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class OriginController extends Controller
{
    public function select(Request $request)
    {
        Cookie::queue("origin", $request->or ?? 1);
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetAmountController extends Controller
{
    public function getAmount(Request $request): \Illuminate\Http\JsonResponse
    {
        $db = $request->db ?? null;
        $id = $request->id ?? null;
        if ($db == null || $id == null) {
            return response()->json(["message" => 'Không tìm thấy CSDL'], 404);
        }
        $entry = DB::table($db)->where("id", $id)->first();
        if ($entry == null) {
            return response()->json(["message" => 'Id không xác định'], 404);
        }
        return response()->json(["amount" => $entry->value]);
    }
}

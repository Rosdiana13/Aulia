<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeadStockController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->days ?? 30;

        $deadstock = DB::table('v_dead_stock')
            ->where('lama_mengendap', '>=', $days)
            ->get();

        return view('deadstock', compact('deadstock', 'days'));
    }
}

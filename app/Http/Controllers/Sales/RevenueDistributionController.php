<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class RevenueDistributionController extends Controller
{
    public function getSalesRevenuedList(Request $request)
    {
        $items = collect(json_decode($request->items, true));

        return response()->view('sales.orders._salesRevenuedList', [
            'items' => $items
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use App\Helpers\Functions;

use App\Models\Account;
use App\Models\RevenueDistribution;

class SaleRevenueController extends Controller
{
    /** 
     * Get form of revenue sharing tool
     * 
     * @return View
     */
    public function getRevenueForm(Request $request): View
    {
        return view('generals.sale_revenue._form', [
            'parentId' => $request->parentId,
            'defaultSaleId' => $request->defaultSaleId,
            'totalPrice' => Functions::convertStringPriceToNumber($request->totalPrice),
            'revenueDistributions' => $request->revenueDistributions
        ]);
    }

    /**
     * Get list of persons revenuing
     * 
     * This function processes revenue distribution data and adjusts the primary 
     * amount based on the total price and cached values. It then returns a view 
     * with the updated revenue data.
     * 
     * @param Request $request The incoming request object containing revenue data,
     *                         default sale ID, total price, and parent ID.
     * 
     * @return View The view displaying the revenue distribution list.
     */
    public function getDistributeList(Request $request): View
    {
        // Decode the revenue data from the request
        $revenueData = json_decode($request->revenueData, true);
        $defaultSaleId = $request->defaultSaleId;
        $totalPrice = Functions::convertStringPriceToNumber($request->totalPrice); // Convert the total price from string to number

        // Use the helper class to process the revenue data
        $processedRevenueData = \App\Helpers\RevenueDistribution::processRevenueData($revenueData, $defaultSaleId, $totalPrice);

        return view('generals.sale_revenue.distribute_list', [
            'parentId' => $request->parentId,
            'revenueData' => $processedRevenueData,
            'defaultSaleId' => $defaultSaleId,
        ]);
    }
}

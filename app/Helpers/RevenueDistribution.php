<?php

namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class RevenueDistribution {
    public static function getRevenueDataWithDefault(int $defaultId): array
    {
        return [
            [
                'account_id' => $defaultId,
                'is_primary' => true,
                'order_item_id' => null,
                'amount' => null
            ]
        ];
    }

    public static function processRevenueDistributeList($revenueList, $defaultSaleId)
    {
        foreach ($revenueList as &$item)
        {
            if ($item['account_id'] == $defaultSaleId) $item['is_primary'] = true;
        }

        unset($item);

        return $revenueList;
    }

    /**
     * Process revenue distribution data and adjust the primary amount.
     * 
     * @param array $revenueData The revenue data to be processed.
     * @param int $defaultSaleId The default sale ID.
     * @param float $totalPrice The total price.
     * 
     * @return array The processed revenue data.
     */
    public static function processRevenueData(array $revenueData, int $defaultSaleId, float $totalPrice): array
    {
        $cacheKey = 'total_price_' . $defaultSaleId; // Generate cache keys for total price and primary amount
        $primaryAmountCacheKey = 'primary_amount_' . $defaultSaleId;
        $previousTotalPrice = Cache::get($cacheKey, 0); // Get the previous total price from the cache, defaulting to 0 if not found

        // Store the total price in the cache for use in the next request (expires in 120 minutes)
        Cache::put($cacheKey, $totalPrice, 120);

        // Initialize amounts for primary and non-primary persons
        $primaryAmount = 0;
        $notPrimaryPersonsAmount = 0;

        // Calculate the total amounts for primary and non-primary persons
        foreach($revenueData as $data) {
            $amount = Functions::convertStringPriceToNumber($data['amount']);

            if (!$data['is_primary']) {
                $notPrimaryPersonsAmount += $amount;
            } else {
                $primaryAmount += $amount;
            }
        }

        // Retrieve the previous primary amount from the cache, defaulting to 0 if not found
        $previousPrimaryAmount = Cache::get($primaryAmountCacheKey, 0);

        // Check and adjust primary amount if necessary
        if ($previousPrimaryAmount == $primaryAmount) {
            if ($totalPrice >= $notPrimaryPersonsAmount) {
                $primaryAmount = $totalPrice - $notPrimaryPersonsAmount;
            } else {
                $primaryAmount = 0;
            }

            // Update revenue data with the new primary amount
            foreach($revenueData as &$data) {
                if ($data['is_primary']) {
                    $data['amount'] = $primaryAmount;
                }
            }
            unset($data); // Unset the reference to avoid unexpected issues
        }

        // Recalculate the primary amount after handling adjustments
        $primaryAmountAfterHandle = 0;

        foreach($revenueData as $data) {
            if ($data['is_primary']) {
                $primaryAmountAfterHandle += Functions::convertStringPriceToNumber($data['amount']);
            }
        }

        // Store the updated primary amount in the cache (expires in 120 minutes)
        Cache::put($primaryAmountCacheKey, $primaryAmountAfterHandle, 120);

        return $revenueData;
    }
}

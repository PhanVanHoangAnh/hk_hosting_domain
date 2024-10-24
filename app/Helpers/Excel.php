<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel 
{
    use HasFactory;

    public static function exportUpsellReportExcelFile($accountId, $fromDate, $toDate) 
    {
        $templatePath = public_path('templates/sales-upsell-report.xlsx');
        $filteredOrderItems = self::filterOrderItems($accountId, $fromDate, $toDate);
        $templateSpreadsheet = IOFactory::load($templatePath);

        OrderItem::exportToExcelUpsellReport($templateSpreadsheet, $filteredOrderItems);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_sales_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return $outputFilePath;
    }

    public static function filterOrderItems($accountId, $fromDate, $toDate)
    {
        $query = OrderItem::query();

        $query->whereHas('orders', function ($subquery) use ($accountId, $fromDate, $toDate) {
            $subquery->where('sale', $accountId);
        });

        if ($fromDate && $toDate) {
            $query = $query->filterByUpdatedAt($fromDate, $toDate);
        }

        $orderItems = $query->get();

        foreach ($orderItems as $item) {
            $item->addRemainTime();
        }

        return $query->get();
    }
}
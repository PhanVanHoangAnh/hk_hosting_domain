<?php

namespace App\Http\Controllers\Sales\Report;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Library\Permission;
use App\Models\Order;
use App\Models\CourseStudent;
use App\Models\StudentSection;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPUnit\TestRunner\TestResult\Collector;
use Illuminate\Support\Facades\Log;

class UpsellReportController extends Controller
{
    public function index(Request $request)
    {
        return view('sales.report.upsell_report.index');
    }

    public function list(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch());
            
            if ($request->account_ids) {
                $query->whereHas('orders', function ($subquery) use ($request) {
                    $subquery->whereIn('sale', $request->account_ids);
                });
            }
        } else {
            // Chỉ lấy báo cáo của current user
            $query = OrderItem::query();
            $query->whereHas('orders', function ($subquery) use ($request) {
                $subquery->where('sale', $request->user()->account->id);
            });
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query->orderBy($sortColumn, $sortDirection);

        $orderItems = $query->get();


        foreach ($orderItems as $item) {
            $item->addRemainTime();
        }

        $orderItems = $orderItems->sortBy('remain_time');

        return view('sales.report.upsell_report.list', [
            'orderItems' => $orderItems,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        $orderItems = OrderItem::all();
        $orderItems = $orderItems->whereIn('sale', $request->account_ids);

        return view('sales.report.upsell_report.exportUpsellReports', [
            'orderItems' => $orderItems,
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/sales-upsell-report.xlsx');
        $filteredOrderItems = $this->filterOrderItems($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        OrderItem::exportToExcelUpsellReport($templateSpreadsheet, $filteredOrderItems);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_sales_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_upsell_report.xlsx');
    }

    public function filterOrderItems(Request $request)
    {
        $query = OrderItem::query();

        if ($request->account_ids) {
            $query->whereHas('orders', function ($subquery) use ($request) {
                $subquery->whereIn('sale', $request->account_ids);
            });
        }
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query->orderBy($sortColumn, $sortDirection);

        $orderItems = $query->get();


        foreach ($orderItems as $item) {
            $item->addRemainTime();
        }

        return $query->get();
    }
}

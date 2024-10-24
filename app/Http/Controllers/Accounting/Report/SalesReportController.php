<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('accounting.reports.sales_report.index');
    }

    public function list(Request $request)
    {
        // $orderIds = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->isActive()->distinct()->pluck('order_id');

        $query = Order::whereHas('paymentRecords');

        // if ($request->account_ids) {
        //     $query = $query->where(function ($query) use ($request) {
        //         $query->whereIn('sale', $request->account_ids)
        //         ->orWhereHas('orderItems.revenues', function ($q1) use ($request) {
        //             $q1->whereIn('account_id', $request->account_ids);
        //         });
        //     });
        // }

        if ($request->account_ids) {
            $query = $query->filterBySales($request->account_ids);
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        $orders = $query->paginate($request->perpage ?? 10);

        return view('accounting.reports.sales_report.list', [
            'orders' => $orders,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('accounting.reports.sales_report.exportSalesReport',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-sales-report.xlsx');
        $filteredOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        // $section_from = $request->input('section_from', null);
        // $section_to = $request->input('section_to', null);

        Order::exportToExcelAccountingSalesReport($templateSpreadsheet, $filteredOrders);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_accounting_sales_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_accounting_sales_report.xlsx');
    }

    public function filterOrders(Request $request)
    {
        $orderIds = OrderItem::orderIsActive()->distinct()->pluck('order_id');

        $query = Order::whereIn('id', $orderIds) 
        ->whereHas('paymentRecords', function ($subquery) {
            $subquery->where('type', PaymentRecord::TYPE_RECEIVED);
        });

        if ($request->account_ids) {
            $query = $query->whereIn('sale', $request->account_ids);
        }

        $updated_at_from = $request->input('updated_at_from', null);
        $updated_at_to = $request->input('updated_at_to', null);

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);
        return $query->get();
    }
}

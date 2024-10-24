<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Library\Permission;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentRecord;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DebtReportController extends Controller
{
    public function index()
    {
        return view('accounting.reports.debt_report.index');
    }

    public function list(Request $request)
    {
        // $orderIds = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->isActive()->distinct()->pluck('order_id');
    

        $query = Order::whereHas('paymentRecords');

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        // Paginate
        $orders = $query->paginate($request->perpage ?? 10);
        return view('accounting.reports.debt_report.list', [
            'orders' => $orders,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        // $orders = Order::all();
        // $orders = $orders->whereIn('sale', $request->account_ids);
        return view('accounting.reports.debt_report.exportDebtReports',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-debt-report.xlsx');
        $filteredOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        Order::exportToExcelDebtReport($templateSpreadsheet, $filteredOrders);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_debt_report.xlsx';

        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_debt_report.xlsx');
    }

    public function filterOrders(Request $request)
    {
        $orderIds = OrderItem::orderIsActive()->distinct()->pluck('order_id');

        $query = Order::whereIn('id', $orderIds) 
        ->whereHas('paymentRecords', function ($subquery) {
            $subquery->where('type', PaymentRecord::TYPE_RECEIVED);
        });

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        return $query->get();
    }
    
}

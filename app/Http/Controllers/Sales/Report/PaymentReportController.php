<?php

namespace App\Http\Controllers\Sales\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Permission;
use App\Models\Order;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PaymentReportController extends Controller
{
    public function index(){
        return view('sales.report.payment_report.index');
    }

    public function list(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch())->getGeneral();

            if ($request->account_ids) {
                $query = $query->whereIn('sale', $request->account_ids);
            }
        } else {
            // Chỉ lấy báo cáo của current user
            $query = $request->user()->account->saleOrders();
        }

        
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        $orders = $query->paginate($request->per_page ?? 10);

        return view('sales.report.payment_report.list', [
            'orders' => $orders,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('sales.report.payment_report.exportPaymentReports',[
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/sales-payment-report.xlsx');
        $filteredOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        Order::exportToExcelPaymentReport($templateSpreadsheet, $filteredOrders);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_sales_payment_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_sales_payment_report.xlsx');
    }

    public function filterOrders(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = Order::query();

            if ($request->account_ids) {
                $query = $query->whereIn('sale', $request->account_ids);
            }
        } else {
            $query = $request->user()->account->saleOrders();
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByCreatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->sortList($sortColumn, $sortDirection);

        return $query->get();
    }
}

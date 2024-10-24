<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Models\PaymentRecord;
use App\Library\Permission;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FeeCollectionReportController extends Controller
{
    public function index()
    {
        return view('accounting.reports.fee_collection_report.index');
    }

    public function list(Request $request)
    {
        // if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
        //     $query = PaymentRecord::query();

        //     if ($request->account_ids) {
        //         $query = $query->whereIn('account_id', $request->account_ids);
        //     }
        // } else {
        //     $query = $request->user()->account->paymentRecords();
        // }
        $query = PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch());

        if ($request->account_ids) {
            $query = $query->whereIn('account_id', $request->account_ids);
        }

        if ($request->has('payment_date_from') && $request->has('payment_date_to')) {
            $payment_date_from = $request->input('payment_date_from');
            $payment_date_to = $request->input('payment_date_to');
            $query = $query->filterByPaymentDate($payment_date_from, $payment_date_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->orderBy($sortColumn, $sortDirection);

        // pagination
        $payments = $query->paginate($request->perpage ?? 10);
        return view('accounting.reports.fee_collection_report.list',[
            'payments' => $payments,
            
        ]);
    }

    public function showFilterForm(Request $request)
    {
        $orders = PaymentRecord::all();
        $orders = $orders->whereIn('account_id', $request->account_ids);

        return view('accounting.reports.fee_collection_report.exportFeeCollectionReports',[
            'orders' => $orders,
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-fee-collection-report.xlsx');
        $filteredOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        PaymentRecord::exportToExcelFeeCollectionReport($templateSpreadsheet, $filteredOrders);

        // Output path

        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_fee_collection_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_fee_collection_report.xlsx');
    }

    public function filterOrders(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = PaymentRecord::query();

            if ($request->account_ids) {
                $query = $query->whereIn('account_id', $request->account_ids);
            }
        } else {
            $query = $request->user()->account->paymentRecords();
        }

        if ($request->has('payment_date_from') && $request->has('payment_date_to')) {
            $payment_date_from = $request->input('payment_date_from');
            $payment_date_to = $request->input('payment_date_to');
            $query = $query->filterByUpdatedAt($payment_date_from, $payment_date_to);
        }

        return $query->get();

    }
}

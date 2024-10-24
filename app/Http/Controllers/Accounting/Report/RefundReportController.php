<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RefundReportController extends Controller
{
    public function index()
    {
        return view('accounting.reports.refund_report.index');
    }

    public function list(Request $request)
    {
        $query = RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->with('student', 'course','courseStudent');

        if ($request->account_ids) {
            $query->whereHas('orderItem', function ($q1) use ($request) {
                $q1->whereHas('orders', function ($q2) use ($request) {
                    $q2->whereIn('sale', $request->account_ids);
                });
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

        $refundRequests = $query->paginate($request->perpage ?? 10);
        return view('accounting.reports.refund_report.list', [
            'refundRequests' => $refundRequests,
          
        ]);
    }

    public function showRequest(Request $request, $id)
    {
        $refundRequest = RefundRequest::find($id);
        $paymentAccounts = PaymentAccount::all();

        return view('edu.refund_requests.showRequest', [
            'paymentAccounts' => $paymentAccounts,
            'refundRequest' => $refundRequest,
            
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('accounting.reports.refund_report.exportRefundReports',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-refund-report.xlsx');
        $filteredRefundRequests = $this->filterRefundRequests($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        RefundRequest::exportToExcelRefundReport($templateSpreadsheet, $filteredRefundRequests);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_accounting_refund_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_accounting_refund_report.xlsx');
    }

    public function filterRefundRequests(Request $request)
    {
        $query = RefundRequest::query()->with('student', 'course','courseStudent');

        if ($request->account_ids) {
            $query->whereHas('orderItem', function ($q1) use ($request) {
                $q1->whereHas('orders', function ($q2) use ($request) {
                    $q2->whereIn('sale', $request->account_ids);
                });
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
        return $query->get();
    }
}

<?php

namespace App\Http\Controllers\Sales\Report;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use App\Library\Permission;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConversionRateReportController extends Controller
{
    public function index() {
        return view('sales.report.conversion_rate.index');
    }

    public function list(Request $request) {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $accounts = Account::byBranch(\App\Library\Branch::getCurrentBranch())->sales();
    
            if ($request->account_ids) {
                $accounts = $accounts->whereIn('id', $request->account_ids);
            }
        } else {
            // Chỉ lấy báo cáo của current user 
            // $accounts = Auth::User();   
            // $accounts = Account::sales();
            $accounts = Account::where('id', $request->user()->account->id);
        }
        $updated_at_from = $request->input('updated_at_from', null);
        $updated_at_to = $request->input('updated_at_to', null);

        
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $accounts = $accounts->orderBy($sortColumn, $sortDirection);

        $accounts = $accounts->paginate($request->per_page ?? 10);

        return view('sales.report.conversion_rate.list', [
            'accounts' => $accounts,
            'request' => $request,
            'updated_at_from' => $updated_at_from,
            'updated_at_to' => $updated_at_to,
            
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('sales.report.conversion_rate.exportConversionRateReports',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/sales-conversion-rate-report.xlsx');
        $filteredAccount = $this->filteredAccount($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        $updated_at_from = $request->input('updated_at_from', null);
        $updated_at_to = $request->input('updated_at_to', null);

        Account::exportToExcelConversionRateReport($templateSpreadsheet, $filteredAccount, $updated_at_from, $updated_at_to);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_sales_conversion_rate_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);  
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_conversion_rate_report.xlsx');
    }

    public function filteredAccount(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $accounts = Account::sales();
    
            if ($request->account_ids) {
                $accounts = $accounts->whereIn('id', $request->account_ids);
            }
        } else {

            $accounts = Account::where('id', $request->user()->account->id);
        }
        
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $accounts = $accounts->orderBy($sortColumn, $sortDirection);


        return $accounts->get();
    }
}

<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Library\Permission;
use App\Models\Account;
use App\Models\KpiTarget;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KPIReportController extends Controller
{
    public function indexDailyKPIReport()
    {
        return view('accounting.reports.kpi_reports.indexDailyKPIReport');
    }
    
    public function listDailyKPIReport(Request $request)
    {
        // if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
        //     $accounts = Account::query();

        //     if ($request->account_ids) {
        //         $accounts = $accounts->whereIn('id', $request->account_ids);
        //     }
        // } else {
        //     $accounts = Account::where('id', $request->user()->account->id);
        // }
        $accounts = Account::sales()->byBranch(\App\Library\Branch::getCurrentBranch());

        if ($request->account_ids) {
            $accounts = $accounts->whereIn('id', $request->account_ids);
        }

        $kpiTargets = KpiTarget::query();
        $sortColumn = $request->sort_by ?? 'id';
        $sortDirection = $request->sort_direction ?? 'asc';

        // if ($request->start_at && $request->end_at) {
        //     $kpiTargets = $kpiTargets->inTimeRange($request->start_at, $request->end_at);
        //     $accountsByKpis = Account::whereIn('id', $kpiTargets->pluck('account_id'));
        //     $ids = $accounts->pluck('id');
        //     $accounts = $accountsByKpis->whereIn('id', $ids);
        // }

        // sort
        $accounts = $accounts->orderBy($sortColumn, $sortDirection);

        //pagination
        $accounts = $accounts->paginate($request->perpage ?? 10);

        return view('accounting.reports.kpi_reports.listDailyKPIReport',[
            'accounts' => $accounts,
            'request' => $request,
            'start' => isset($request->start_at) ? $request->start_at : null,
            'end' => isset($request->end_at) ? $request->end_at : null,
        ]);
    }

    public function showFilterForm(Request $request)
    {

        return view('accounting.reports.kpi_reports.exportListDailyKPIReport', [
        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-kpi-report.xlsx');
        $filteredAccount = $this->filteredAccount($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        // Get start and end from the request
        $start = $request->start_at ?? null;
        $end = $request->end_at ?? null;

        Account::exportToExcelKpiReport($templateSpreadsheet, $filteredAccount, $request, $start, $end);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_kpi_report.xlsx';

        $outputFilePath = $storagePath . '/' . $outputFileName;

        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');
        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_kpi_report.xlsx');
    }

    public function filteredAccount(Request $request)
    {
        $accounts = Account::query();

        if ($request->account_ids) {
            $accounts = $accounts->whereIn('id', $request->account_ids);
        }

        $kpiTargets = KpiTarget::query();
        $sortColumn = $request->sort_by ?? 'id';
        $sortDirection = $request->sort_direction ?? 'asc';

        if ($request->start_at && $request->end_at) {
            $kpiTargets = $kpiTargets->inTimeRange($request->start_at, $request->end_at);
            $accountsByKpis = Account::whereIn('id', $kpiTargets->pluck('account_id'));
            $ids = $accounts->pluck('id');
            $accounts = $accountsByKpis->whereIn('id', $ids);
        }

        $accounts = $accounts->orderBy($sortColumn, $sortDirection);
        return $accounts->get();
    }
}

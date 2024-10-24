<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Contact;
use App\Models\Account;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('marketing.reports.index');
    }
    public function downloadExcelReport(Request $request)
    {
        $templatePath = public_path('templates/report.xlsx');
        $templateSpreadsheet = IOFactory::load($templatePath);
        $xColumns = $request->report['xColumns'];
        $yColumns = $request->report['yColumns'];
        $data = $request->report['data'];
        $xTotal = $request->report['xTotal'];
        $yTotal = $request->report['yTotal'];
        $total = $request->report['total'];
        $data_1 = $request->report['data_1'] ?? null;
        $xTotal_1 = $request->report['xTotal_1'] ?? null;
        $yTotal_1 = $request->report['yTotal_1'] ?? null;
        $total_1 = $request->report['total_1'] ?? null;
        $data_2 = $request->report['data_2'] ?? null;
        $xTotal_2 = $request->report['xTotal_2'] ?? null;
        $yTotal_2 = $request->report['yTotal_2'] ?? null;
        $total_2 = $request->report['total_2'] ?? null;

        \App\Library\Report::exportExcel($templateSpreadsheet, $xColumns, $yColumns, $data, $xTotal, $yTotal, $total, $data_1, $xTotal_1, $yTotal_1, $total_1, $data_2, $xTotal_2, $yTotal_2, $total_2);
        $storagePath = storage_path('app/exports');
        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }
    
    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'report.xlsx');
    }

    public function loadView(Request $request)
    {
        $views = $request->user()->getReportViews();
        $name = $request->name;
        $data = $views[$name];
        return response()->json(['data' =>  $data]);
    }

    public function viewButtons(Request $request)
    {
        $views = $request->user()->getReportViews();

        return view('marketing.reports.viewButtons', [
            'views' => $views,
        ]);
    }

    public function addView(Request $request)
    {
        $name = $request->name;
        $data = $request->data;

        $request->user()->addReportView($name, $data);
    }

    public function removeView(Request $request)
    {
        $name = $request->name;

        $request->user()->removeReportView($name);
    }

    public function result(Request $request)
    {
        $xType = $request->x_type;
        $yType = $request->y_type;
        $dataType = $request->data_type;
        $filterType = $request->filter_type;
        //
        $report = \App\Library\Report::getMarketingReport($xType, $yType, $dataType, $filterType);
        return view('marketing.reports.result', [
            'report' => $report,
        ]);
    }

    public function createButtonName()
    {
        return view('marketing.reports.createButtonName');
    }
}

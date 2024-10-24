<?php

namespace App\Http\Controllers\Accounting\Report;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DemoReportController extends Controller
{
    public function index(){
        return view('accounting.reports.demo_report.index');
    }

    public function list(Request $request){
        // In case the user clicks on report (sends a request without sufficient information) 
        // Or when the page is newly loaded
        // => return an empty collection
        $query = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->typeRequestDemo();

        // In case the user clicks on the report with full information
        if ($request->account_ids && $request->has('updated_at_from') && $request->has('updated_at_to')) {
            $query->whereHas('orders', function ($subquery) use ($request) {
                $subquery->whereIn('sale', $request->account_ids);
            });

            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');

            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
            
            $sortColumn = $request->sort_by ?? 'updated_at';
            $sortDirection = $request->sort_direction ?? 'desc';
    
            $query->orderBy($sortColumn, $sortDirection);
    
            $classes = $query->paginate($request->perpage ?? 10);

            return view('accounting.reports.demo_report.list', [
                'classes' => $classes,
            ]);
        }

        

        $classes = $query->paginate($request->perpage ?? 10);
        
        // Remove all elements from the collection, returning an empty collection."
        foreach ($classes as $key => $value) {
            unset($classes[$key]);
        }

        return view('accounting.reports.demo_report.list', [
            'classes' => $classes
        ]);
        
    }
    public function showFilterForm(Request $request)
    {
        return view('accounting.reports.demo_report.exportDemoReports', [

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/accounting-demo-report.xlsx');
        $filteredOrderItems = $this->filterOrderItems($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        OrderItem::exportToExcelDemoReport($templateSpreadsheet, $filteredOrderItems);

        // Output path
        $storagePath = storage_path('app/exports');

        if (!file_exists($storagePath)) {
            // Nếu thư mục không tồn tại, tạo nó
            mkdir($storagePath, 0777, true);
        }

        $outputFileName = 'filtered_accounting_demo_report.xlsx';
        $outputFilePath = $storagePath . '/' . $outputFileName;
        $writer = IOFactory::createWriter($templateSpreadsheet, 'Xlsx');

        $writer->save($outputFilePath);

        return response()->json(['file' => $outputFilePath]);
    }

    public function exportDownload(Request $request)
    {
        $outputFilePath = $request->input('file');

        return response()->download($outputFilePath, 'filtered_accounting_demo_report.xlsx');
    }

    public function filterOrderItems(Request $request)
    {
        $query = OrderItem::typeRequestDemo();

        // In case the user clicks on the report with full information
        if ($request->account_ids && $request->has('updated_at_from') && $request->has('updated_at_to')) {
            $query->whereHas('orders', function ($subquery) use ($request) {
                $subquery->whereIn('sale', $request->account_ids);
            });

            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');

            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
            
            $sortColumn = $request->sort_by ?? 'updated_at';
            $sortDirection = $request->sort_direction ?? 'desc';
    
            $query->orderBy($sortColumn, $sortDirection);
    
            $classes = $query->paginate($request->perpage ?? 10);

            return view('accounting.reports.demo_report.list', [
                'classes' => $classes,
            ]);
        }

        // In case the user clicks on report (sends a request without sufficient information) 
        // Or when the page is newly loaded
        // => return an empty collection
        $query = OrderItem::typeRequestDemo();

        $classes = $query->paginate($request->perpage ?? 10);
        
        // Remove all elements from the collection, returning an empty collection."
        foreach ($classes as $key => $value) {
            unset($classes[$key]);
        }
        return $classes->get();
    }
}

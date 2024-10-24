<?php

namespace App\Http\Controllers\Sales\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Library\Permission;
use App\Models\OrderItem;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('sales.report.sales_report.index');
    }

    public function list(Request $request)
    {
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = OrderItem::byBranch(\App\Library\Branch::getCurrentBranch());
            $query->orderIsApproved()->distinct();
           
            if ($request->has('account_ids')) {
                $orderIds = $query->whereHas('order.salesperson', function ($subquery) use ($request) {
                    $subquery->whereIn('id', $request->account_ids);
                })->pluck('order_id');
            } else {
                $orderIds = $query->pluck('order_id');
            } 
        }
        else{
            $orderIds = OrderItem::orderIsApproved()
            ->whereHas('orders.salesperson', function ($subquery) use ($request) {
                $subquery->whereIn('id', [$request->user()->account->id]);
            })
            ->distinct()
            ->pluck('order_id');
        }

       

        $query = Order::whereIn('id', $orderIds) 
        ->whereHas('paymentRecords', function ($subquery) {
            $subquery->where('type', PaymentRecord::TYPE_RECEIVED);
        });

        if($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }
        
        if($request->types) {
            $query = $query->filterByTypes($request->types);
        }
        
        if($request->sales) {
            $query = $query->filterBySales($request->sales);
        }
        
        if($request->saleSups) {
            $query = $query->filterBySaleSups($request->saleSups);
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

        return view('sales.report.sales_report.list', [
            'orders' => $orders,
        ]);
    }

    public function showFilterForm(Request $request)
    {
        return view('sales.report.sales_report.exportSalesReports',[

        ]);
    }

    public function exportRun(Request $request)
    {
        $templatePath = public_path('templates/sales-sales-report.xlsx');
        $filteredOrders = $this->filterOrders($request);
        $templateSpreadsheet = IOFactory::load($templatePath);

        Order::exportToExcelSalesReport($templateSpreadsheet, $filteredOrders);

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

        return response()->download($outputFilePath, 'filtered_sales_report.xlsx');
    }

    public function filterOrders(Request $request)
    {
        $orderIds = OrderItem::orderIsActive()->distinct()->pluck('order_id');

        $query = Order::whereIn('id', $orderIds) 
        ->whereHas('paymentRecords', function ($subquery) {
            $subquery->where('type', PaymentRecord::TYPE_RECEIVED);
        });

        if($request->industries) {
            $query = $query->filterByIndustries($request->industries);
        }
        
        if($request->types) {
            $query = $query->filterByTypes($request->types);
        }
        
        if($request->sales) {
            $query = $query->filterBySales($request->sales);
        }
        
        if($request->saleSups) {
            $query = $query->filterBySaleSups($request->saleSups);
        }
        
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

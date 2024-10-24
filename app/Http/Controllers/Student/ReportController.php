<?php

namespace App\Http\Controllers\Student;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Facades\Response;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Order;
use App\Models\OrderItem;

class ReportController extends Controller
{   
    // public function contractStatusReport(Request $request)
    // {
    //     return view('student.report.contract-status-report');
    // }

    // public function salesReport(Request $request)
    // {
    //     $orders = Order::all();
    //     return view('student.report.sales-report',[
    //         'orders'=> $orders,
    //     ]);
    // }

    // public function dailyKPIReport(Request $request)
    // {
    //     return view('student.report.daily-kpi-report');
    // }

    // public function monthlyKPIReport(Request $request)
    // {
    //     return view('student.report.monthly-kpi-report');
    // }

    // public function upsellReport(Request $request)
    // {
    //     return view('student.report.upsell-report');
    // }

    // public function paymentReport(Request $request)
    // {
    //     return view('student.report.payment-report');
    // }

    // public function revenueReport(Request $request)
    // {
    //     return view('student.report.revenue-report');
    // }
}

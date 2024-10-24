<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentRecord;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request, $interval = 'week')
    {
        
        $orders = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted();
        
        $types = Order::getAllTypeVariable();
        

        //index
        $sumTotalCacheThisMonth =  $orders->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->sum('cache_total');
     
        
        $sumAmountReachingDueDate = PaymentReminder::sumAmountReachingDueDateNotPaid(PaymentReminder::query());
        $sumAmountOutDueDate = PaymentReminder::sumAmountOutDueDateNotPaid(PaymentReminder::query());

        
        $sumAmountPaid = PaymentRecord::sumAmountReceivedThisMonth(PaymentRecord::query());
        $sumAmountRefund = PaymentRecord::sumAmountRefundThisMonth(PaymentRecord::query());

        
        //module 1
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subWeek();
        $cacheTotalChart = $this->getCacheTotalChart( $startDate, $endDate, $interval);
        
        $paidChart = $this->getPaidChart( $startDate, $endDate, $interval);
        

        //module 2
        $paidTypes = $this->getPaidTypes( $types);


        //module 3
        $newOrderThisMonth = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)
        ->whereMonth('order_date', now()->month)->count();
        $orderPaid =  Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)
        ->whereMonth('order_date', now()->month)->checkIsPaid();
        $orderDebt =  Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)
        ->whereMonth('order_date', now()->month)->checkIsNotPaid();
        $pendingOrderCount = Order::byBranch(\App\Library\Branch::getCurrentBranch())->getGeneral()->pending()->whereYear('order_date', now()->year)
        ->whereMonth('order_date', now()->month)
        ->count();
        $rejectedOrderCount = Order::byBranch(\App\Library\Branch::getCurrentBranch())->getGeneral()->rejected()->whereYear('order_date', now()->year)
        ->whereMonth('order_date', now()->month)
        ->count();

        //module 6
        $typesCount = $this->getTypesCounts( $types);

        $newOrderCount =  Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->checkIsNotPaid()->count();
        $orderPartPaidCount = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->partPaid()->checkIsNotPaid()->count();
        $orderPaidCount = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->checkIsPaid()->count();
        $orderAllCount = Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDeleted()->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->count();
        
        return view('accounting.dashboard.index', [
            //index
            'sumTotalCacheThisMonth' => $sumTotalCacheThisMonth,
            'sumAmountReachingDueDate' => $sumAmountReachingDueDate,
            'sumAmountPaid' => $sumAmountPaid,
            'sumAmountRefund' => $sumAmountRefund,
            'sumAmountOutDueDate' => $sumAmountOutDueDate,

            //module 1
            'cacheTotalChart' => $cacheTotalChart,
            'paidChart' =>$paidChart,

            //module 2
            'paidTypes' => $paidTypes,
            
            //module 3
            'newOrderThisMonth' => $newOrderThisMonth,
            'orderPaid' => $orderPaid,
            'orderDebt' => $orderDebt,
            'pendingOrderCount' => $pendingOrderCount,
            'rejectedOrderCount' => $rejectedOrderCount,
            
            //module6
            'typesCount' => $typesCount,

            'newOrderCount' => $newOrderCount,
            'orderPartPaidCount' => $orderPartPaidCount,
            'orderPaidCount' => $orderPaidCount,
            'orderAllCount' => $orderAllCount,  
        ] );
    }

    
    public function updateInterval(Request $request, $interval)
    {
        // get account
       
        
        $endDate = Carbon::now()->endOfDay();
        $dateRange = $this->getDateRangeForInterval($request, $interval, $endDate);

        
        $cacheTotalChart = $this->getCacheTotalChart( $dateRange['startDate'], $dateRange['endDate'], $interval);
        $paidChart = $this->getPaidChart( $dateRange['startDate'], $dateRange['endDate'], $interval);

        $data = [
            'xAxisData' => array_keys($paidChart),
            'cacheTotalChart' => array_values($cacheTotalChart),
            'paidChart' => array_values($paidChart),
            
        ];

        return response()->json($data);
    }
    private function getDateRangeForInterval($request, $interval, $endDate)
    {
        $startDate = $endDate->copy();

        if ($interval === 'week') {
            $startDate->subDays(7)->endOfDay();
        } elseif ($interval === 'month') {
            $startDate->subDays(30);
        } elseif ($interval === 'year') {
            $startDate->subMonths(11);
        }elseif ($interval === 'custom') {
            $customStartDate = Carbon::parse($request->input('custom_date_from'));
            $customEndDate = Carbon::parse($request->input('custom_date_to'));
    
            $startDate = $customStartDate;
            $endDate = Carbon::parse($customEndDate);
        }

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

        private function processChartData($data, $startDate, $endDate, $interval)
        {
            $chartData = [];

            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            if ($interval === 'month' ) {
                $currentDate = $startDate->copy();

                while ($currentDate->lte($endDate)) {
                    $chartData[$currentDate->format('j')] = 0;
                    $currentDate->addDay();
                }

            } elseif ($interval === 'year') {
                $currentMonth = $startDate->format('M');
                if($currentMonth ==='Jan') $currentMonth = 'T1';
                if($currentMonth ==='Feb') $currentMonth = 'T2';
                if($currentMonth ==='Mar') $currentMonth = 'T3';
                if($currentMonth ==='Apr') $currentMonth = 'T4';
                if($currentMonth ==='May') $currentMonth = 'T5';
                if($currentMonth ==='Jun') $currentMonth = 'T6';
                if($currentMonth ==='Jul') $currentMonth = 'T7';
                if($currentMonth ==='Aug') $currentMonth = 'T8';
                if($currentMonth ==='Sep') $currentMonth = 'T9';
                if($currentMonth ==='Oct') $currentMonth = 'T10';
                if($currentMonth ==='Nov') $currentMonth = 'T11';
                if($currentMonth ==='Dec') $currentMonth = 'T12';
                $monthsOfYear = [
                    'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'
                ];
                $currentMonthIndex = array_search($currentMonth, $monthsOfYear);
                    for ($i = $currentMonthIndex; $i <= $currentMonthIndex + 11; $i++) {
                    $chartData[$monthsOfYear[$i % 12]] = 0;
                }
            }elseif ($interval === 'custom') {
                $currentDate = $startDate->copy();
                
                while ($currentDate->lte($endDate)) {
                    $chartData[$currentDate->format('d')] = 0;
                    $currentDate->addDay();
                }
            } else {
                $currentDayOfWeek = $startDate->dayOfWeek;
                $daysOfWeek = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'];

                $daysOfWeek = array_merge(array_slice($daysOfWeek, $currentDayOfWeek), array_slice($daysOfWeek, 0, $currentDayOfWeek));
                
                foreach ($daysOfWeek as $day) {
                    $chartData[$day] = 0;
                }
            }

            foreach ($data as $createdAt => $amount) {
                $date = \Carbon\Carbon::parse($createdAt);

                if ($interval === 'month') {

                    $day = $date->format('j');
                    
                } elseif ($interval === 'year') {
                    $day = $date->format('M');
                    if($day ==='Jan') $day = 'T1';
                    if($day ==='Feb') $day = 'T2';
                    if($day ==='Mar') $day = 'T3';
                    if($day ==='Apr') $day = 'T4';
                    if($day ==='May') $day = 'T5';
                    if($day ==='Jun') $day = 'T6';
                    if($day ==='Jul') $day = 'T7';
                    if($day ==='Aug') $day = 'T8';
                    if($day ==='Sep') $day = 'T9';
                    if($day ==='Oct') $day = 'T10';
                    if($day ==='Nov') $day = 'T11';
                    if($day ==='Dec') $day = 'T12';
                }elseif ($interval === 'custom') {
                    $day = $date->format('d');
                } else {
                    $day = $date->format('D');
                    if($day === 'Mon') $day = 'Thứ 2';
                    if($day === 'Tue') $day = 'Thứ 3';
                    if($day === 'Wed') $day = 'Thứ 4';
                    if($day === 'Thu') $day = 'Thứ 5';
                    if($day === 'Fri') $day = 'Thứ 6';
                    if($day === 'Sat') $day = 'Thứ 7';
                    if($day === 'Sun') $day = 'CN';
                }

                if (array_key_exists($day, $chartData)) {
                    $chartData[$day]+= $amount;
                }
            }

            return $chartData;
        }

    private function getCacheTotalChart( $startDate, $endDate, $interval)
    {
        $order = Order::byBranch(\App\Library\Branch::getCurrentBranch())->approved();
        $order = $order->whereBetween('order_date', [$startDate, $endDate])->get();
        
        $totalByDate = $order->groupBy('order_date')->map(function ($group) {
            return $group->sum('cache_total');
        });

        $order = $this->processChartData($totalByDate, $startDate, $endDate, $interval);
        return $order;
    }

    private function getPaidChart( $startDate, $endDate, $interval)
    {
    
        $paid = PaymentRecord::query();
        $paid = $paid->whereBetween('created_at', [$startDate, $endDate])->get();
         
        $totalpaid = $paid->groupBy('created_at')->map(function ($group) {
            return $group->sum('amount');
        });
        $ordersCountChart = $this->processChartData($totalpaid, $startDate, $endDate, $interval);

        return $ordersCountChart;
    }

    private function getTypesCounts( $types)
    {
        $typesCount = [];

        foreach ($types as $type) {
            

            $count = Order::byBranch(\App\Library\Branch::getCurrentBranch())->where('type', $type)->whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)
                ->count();
                $typesCount[$type] = $count;
        }

        return $typesCount;
    }

    private function getPaidTypes($types)
    {
        $typesAmount = [];

        foreach ($types as $type) {
            

            foreach ($types as $type) {
                $paymentRecords = PaymentRecord::query()->join('orders', 'payment_records.order_id', '=', 'orders.id')
                    ->received()
                    ->whereYear('payment_records.created_at', now()->year)
                    ->whereMonth('payment_records.created_at', now()->month)
                    ->where('orders.type', $type)
                    ->sum('amount');
        
                    $typesAmount[$type] = $paymentRecords;
            }
        }

        return $typesAmount;
    }
}

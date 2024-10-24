<?php

namespace App\Http\Controllers\Marketing;

use App\Models\ContactRequest;
use App\Models\Contact;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('marketing.dashboard.index');
    }

    public function conversionRate()
    {
        $fromDate = Carbon::now()->startOfMonth();
        $toDate = Carbon::now()->endOfMonth();

        $orderCount = Order::whereBetween('created_at', [$fromDate, $toDate])->count();
        $requestCount = ContactRequest::whereBetween('created_at', [$fromDate, $toDate])->count();
        $customerCount = Contact::isCustomer()->whereBetween('created_at', [$fromDate, $toDate])->count();
        $contactCount = Contact::active()->whereBetween('created_at', [$fromDate, $toDate])->count();

        $orderRequestRate = \App\Helpers\Functions::calculatePercentage($orderCount, $requestCount, 2);
        $customerContactRate = \App\Helpers\Functions::calculatePercentage($customerCount, $contactCount, 2);


        return view('marketing.dashboard._conversion_rate', [
            'orderCount' => $orderCount,
            'requestCount'  => $requestCount,
            'customerCount' => $customerCount,
            'contactCount' => $contactCount,
            'orderRequestRate' => $orderRequestRate,
            'customerContactRate' => $customerContactRate,
        ]);
    }

    public function module1(Request $request, $interval = 'week')
    {
        $endDate = Carbon::now();
        $dateRange = $this->getDateRangeForInterval($request, $interval, $endDate);
    
        // $contactCountsChart = $this->getContactCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);
        $contactRequestCountsChart = $this->getContactRequestCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);
        $orderCountsChart = $this->getOrderCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);


        return view('marketing.dashboard._module1', [
            // 'contactCountsChart' => $contactCountsChart,
            'contactRequestCountsChart' => $contactRequestCountsChart,
            'orderCountsChart' => $orderCountsChart,
           
        ]);
    }

    public function module3()
    {
        $totalContactCount = ContactRequest::activeCount();

        return view('marketing.dashboard._module3', [
            'totalContactCount' => $totalContactCount,
        ]);
    }

    public function module2()
    {
        $leadStatus = array_filter(config('leadStatuses'), function ($leadStatus) {
            return $leadStatus != ContactRequest::LS_NA;
        });
  
        $countLeadStatuses = $this->getLeadStatusCounts($leadStatus);

        return view('marketing.dashboard._module2', [
            'countLeadStatuses' => $countLeadStatuses,
        ]);
    }

    public function module4()
    {
        $channels = config('marketingSources');
        $totalContactCount = ContactRequest::activeCount();

        return view('marketing.dashboard._module4', [
            'contactCounts' => $this->getContactRequestCountsByChannel($channels),
            'totalContactCount' => $totalContactCount,
        ]);
    }

    public function updateInterval(Request $request, $interval)
    {
        $endDate = Carbon::now()->endOfDay();
        $dateRange = $this->getDateRangeForInterval($request, $interval, $endDate);
        $contactCountsChart = $this->getContactCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);
        $contactRequestCountsChart = $this->getContactRequestCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);
        $orderCountsChart = $this->getOrderCountsChart($dateRange['startDate'], $dateRange['endDate'], $interval);

        $data = [
            'xAxisData' => array_keys($orderCountsChart),
            'contactRequestCountsChart' => array_values($contactRequestCountsChart),
            'contactCountsChart' => array_values($contactCountsChart),
            'orderCountsChart' => array_values($orderCountsChart),
        ];

        return response()->json($data);
    }

    private function getDateRangeForInterval($request, $interval, $endDate)
    {
        $startDate = $endDate->copy();

        if ($interval === 'week') {
            $startDate->subDays(7)->endOfDay();
        } elseif ($interval === 'month') {
            // $startDate->startOfMonth();
            $startDate->subDays(30);
        } elseif ($interval === 'year') {
            $startDate->subMonths(11);
        } elseif ($interval === 'custom') {
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
                $chartData[$currentDate->format('d/m')] = 0;
                $currentDate->addDay();
            }
        
        } elseif ($interval === 'year') {
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $month = $currentDate->format('m'); 
                $year = $currentDate->format('Y');
                $formattedMonthYear = "$month/$year";
                $chartData[$formattedMonthYear] = 0;
                $currentDate->addMonth();
            }

            // $currentMonth = $startDate->format('M');
            // if($currentMonth ==='Jan') $currentMonth = 'T1';
            // if($currentMonth ==='Feb') $currentMonth = 'T2';
            // if($currentMonth ==='Mar') $currentMonth = 'T3';
            // if($currentMonth ==='Apr') $currentMonth = 'T4';
            // if($currentMonth ==='May') $currentMonth = 'T5';
            // if($currentMonth ==='Jun') $currentMonth = 'T6';
            // if($currentMonth ==='Jul') $currentMonth = 'T7';
            // if($currentMonth ==='Aug') $currentMonth = 'T8';
            // if($currentMonth ==='Sep') $currentMonth = 'T9';
            // if($currentMonth ==='Oct') $currentMonth = 'T10';
            // if($currentMonth ==='Nov') $currentMonth = 'T11';
            // if($currentMonth ==='Dec') $currentMonth = 'T12';
            // $monthsOfYear = [
            //     'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'
            // ];
            // $currentMonthIndex = array_search($currentMonth, $monthsOfYear);
            // for ($i = $currentMonthIndex; $i <= $currentMonthIndex + 11; $i++) {
            //     $chartData[$monthsOfYear[$i % 12]] = 0;
            // }
            
        }elseif ($interval === 'custom') {
            $currentDate = $startDate->copy();
            
            while ($currentDate->lte($endDate)) {
                $chartData[$currentDate->format('d/m')] = 0;
                $currentDate->addDay();
            }
        } else {
            $currentDayOfWeek = $startDate->dayOfWeek;
            $daysOfWeek = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];

            $daysOfWeek = array_merge(array_slice($daysOfWeek, $currentDayOfWeek), array_slice($daysOfWeek, 0, $currentDayOfWeek));

            foreach ($daysOfWeek as $day) {
                $chartData[$day] = 0;
            }
        }

        foreach ($data as $item) {
            

            if ($interval === 'month') {
                $day = Carbon::parse($item->created_at)->format('d/m');
            } elseif ($interval === 'year') {
                $month = Carbon::parse($item->created_at)->format('m'); 
                $year = Carbon::parse($item->created_at)->format('Y');
                $day = "$month/$year";

                // $day = Carbon::parse($item->created_at)->format('M');
                // if($day ==='Jan') $day = 'T1';
                // if($day ==='Feb') $day = 'T2';
                // if($day ==='Mar') $day = 'T3';
                // if($day ==='Apr') $day = 'T4';
                // if($day ==='May') $day = 'T5';
                // if($day ==='Jun') $day = 'T6';
                // if($day ==='Jul') $day = 'T7';
                // if($day ==='Aug') $day = 'T8';
                // if($day ==='Sep') $day = 'T9';
                // if($day ==='Oct') $day = 'T10';
                // if($day ==='Nov') $day = 'T11';
                // if($day ==='Dec') $day = 'T12';
            } elseif ($interval === 'custom') {
                $day = Carbon::parse($item->created_at)->format('d/m');
            } else {
                $day = Carbon::parse($item->created_at)->format('D');
                if($day === 'Mon') $day = 'Thứ 2';
                if($day === 'Tue') $day = 'Thứ 3';
                if($day === 'Wed') $day = 'Thứ 4';
                if($day === 'Thu') $day = 'Thứ 5';
                if($day === 'Fri') $day = 'Thứ 6';
                if($day === 'Sat') $day = 'Thứ 7';
                if($day === 'Sun') $day = 'Chủ nhật';
            }

            if (array_key_exists($day, $chartData)) {
                // Trường hợp cùng thứ thì phải cùng ngày hiện tại, để khòi lấy tuần trước
                $chartData[$day]++;
            }
        }

        return $chartData;
    }

    private function getContactCountsChart($startDate, $endDate, $interval)
    {
        $contacts = Contact::whereBetween('created_at', [$startDate, $endDate])->get();
        $contactCountsChart = $this->processChartData($contacts, $startDate, $endDate, $interval);
        return $contactCountsChart;
    }

    private function getContactRequestCountsChart($startDate, $endDate, $interval)
    {
        $contactRequests = ContactRequest::active()->whereBetween('created_at', [$startDate, $endDate])->get();
        $contactRequestCountsChart = $this->processChartData($contactRequests, $startDate, $endDate, $interval);
        return $contactRequestCountsChart;
    }

    private function getOrderCountsChart($startDate, $endDate, $interval)
    {
        $query = Order::notDeleted()->whereBetween('created_at', [$startDate, $endDate])->get();
        $data = $this->processChartData($query, $startDate, $endDate, $interval);
        return $data;
    }


    private function getContactRequestCountsByChannel($channels)
    {
        $contactCounts = [];
        foreach ($channels as $channel) {
            $count = ContactRequest::active()->where('channel', $channel)->count();
            $contactCounts[$channel] = $count;
        }
        return $contactCounts;
    }

    private function getLeadStatusCounts($leadStatus)
    {
        $countLeadStatuses = [];
        foreach ($leadStatus as $status) {
            $count = ContactRequest::active()->where('lead_status', $status)->count();
            $countLeadStatuses[$status] = $count;
        }
        return $countLeadStatuses;
    }
}
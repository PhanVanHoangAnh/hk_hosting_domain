<?php

namespace App\Http\Controllers\Sales;

use App\Models\ContactRequest;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Account;
use App\Library\Permission;
use App\Http\Controllers\Controller;
use App\Models\AccountGroup;
use App\Models\AccountKpiNote;
use App\Models\PaymentRecord;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;
use App\Library\Branch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getAccount(Request $request)
    {
        // Mặc định luôn là tài khoản của current user
        $user = $request->user();
     
        $account = $user->account;

        // Nếu user là manager và chọn account khác thì cho phép xem theo account khác
        if ($request->user()->can('changeBranch', \App\Library\Branch::class)) {
            if ($request->account_id) {
                $account = Account::find($request->account_id);
            
            // xem tất cả tài khoảng
            } elseif ($request->account_id == 'all') {
                $account = null;
            }
        }

        return $account;
    }

    public function getAccountGroup(Request $request)
    {
        $user = $request->user();
        $account = $user->account;
        $accountGroup = null;
        
        if ($request->user()->can('changeBranch', \App\Library\Branch::class)) {
            if ($request->has('account_group_id')) {
                $accountGroup = AccountGroup::find($request->account_group_id);

                if (!$accountGroup) {
                    return null;
                }
            }
            else {
                $accountGroup = $account->accountGroup;
            }
        }

        return $accountGroup;
    }

    public function index(Request $request, $interval = 'week')
    {
        $user = $request->user();
        $accountGroup = null;

        if ($request->has('account_id')) {
            if ($user->can('changeBranch', \App\Library\Branch::class) || $user->can('mentor', \App\Models\User::class) || $user->can('manager', \App\Models\User::class)) { 
                $account = Account::find($request->account_id);
            }
            else {
                abort(403, 'Forbidden');
            }
        } else {
            $account = $user->account;
        }
        
        if ($request->has('account_group_id')) {
            if ($request->user()->can('changeBranch', \App\Library\Branch::class)) {
                $accountGroup = AccountGroup::find($request->account_group_id);
            }
            else {
                // abort(403, 'Forbidden');
                $accountGroup = $account->accountGroup;
            }
        }

        if ($request->has('branch')) {
            if ($user->can('changeBranch', \App\Library\Branch::class) || $user->can('mentor', \App\Models\User::class) || $user->can('manager', \App\Models\User::class)) {    
                $branch = $request->branch;
            }
            
        } else {
            $branch = null;
        }
 
        $leadStatus = config('leadStatuses');
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subWeek();
        $contactRequestCountChart = $this->getContactRequestCountsChart($branch, $account, $accountGroup, $startDate, $endDate, $interval);
        $ordersCountChart = $this->getOrdersCountsChart($branch, $account, $accountGroup, $startDate, $endDate, $interval);
        $contactRequestCount=  $this->getContactRequest($branch, $account, $accountGroup)->count();
        $leadStatusesCount = $this->getLeadStatusCounts($branch, $account, $accountGroup, $leadStatus);
        $types = Order::getAllTypeVariable();
        $typesCount = $this->getTypesCounts($branch,  $account,$accountGroup,$types);
        $paidChart = $this->getPaidChart($branch, $account,$accountGroup, $startDate, $endDate, $interval);
        $cacheTotalChart = $this->getCacheTotalChart($branch, $account,$accountGroup, $startDate, $endDate, $interval);
        
        return view('sales.dashboard.index', [
            'account' => $account,
            'accountGroup' => $accountGroup,
            'branch' => $branch,
            'contactRequestCountChart' => $contactRequestCountChart,
            'ordersCountChart' => $ordersCountChart,
            'contactRequestCount' => $contactRequestCount,
            'leadStatusesCount' => $leadStatusesCount,

            // index
            'noActionContactRequestCount' => $this->getNoActionContactRequestCount($account,$accountGroup),
            'newContactRequestThisMonthCount' => $this->getNewContactRequestThisMonthCount($branch, $account,$accountGroup),
            'overDueRemindersCount' => $this->getOverDueRemindersCount($account,$accountGroup),
            'reachingDueDateRemindersCount' => $this->getReachingDueDateRemindersCount($account,$accountGroup),
            'accountKpiNoteOutDateCount' => $this->getAccountKpiNoteOutDateCount($account,$accountGroup),
            'newCustomerThisMonthCount' => $this->getNewCustomerThisMonthCount($account),
            'requestDemoCount' => $this->getRequestDemoCount($account),
            'newContractThisMonthCount' => $this->getNewContractThisMonthCount($account),

            // module3
            'orderThisMonthCount' => $this->getOrderThisMonthCount($branch, $account,$accountGroup),
            'draftOrderCount' => $this->getDraftOrderCount($branch, $account,$accountGroup),
            'pendingOrderCount' => $this->getPendingOrderCount($branch, $account, $accountGroup),
            'activeOrderCount' => $this->getActiveOrderCount($branch, $account, $accountGroup),
            'rejectedOrderCount' => $this->getRejectedOrderCount($branch, $account, $accountGroup),

            //orderType
            'typesCount' => $typesCount,

            // module6
            'orderCount' => $this->getOrderByAccoutCount($branch, $account,$accountGroup),
            'totalKPIRevenueOrderThisMonth' =>  $this->getTotalKPIRevenueOrderThisMonth($branch, $account, $accountGroup),
            'kpiTargetByMonth' => $this->getLatestKpiTargetAmountByMonth($account),
            'totalKPIRevenueOrderThisQuarter' =>  $this->getTotalKPIRevenueOrderThisQuarter($branch, $account, $accountGroup),
            'kpiTargetByQuarter' => $this->getLatestKpiTargetAmountByQuater($account, $accountGroup),
            
             //revenueFluc
             'cacheTotalChart' => $cacheTotalChart,
             'paidChart' =>$paidChart,
        ]);
    }

    private function getCacheTotalChart($branch, $account, $accountGroup, $startDate, $endDate, $interval)
    {
        $order = $this->getOrder($branch, $account, $accountGroup)->approved(); 
        $order = $order->whereBetween('created_at', [$startDate, $endDate])->get();
        $totalByDate = $order->groupBy('created_at')->map(function ($group) {
            return $group->sum('cache_total');
        });
        $order = $this->processChartDataRevenue($totalByDate, $startDate, $endDate, $interval);
        
        return $order;
    }

    private function getPaidChart($branch, $account, $accountGroup, $startDate, $endDate, $interval)
    {
        $query = $this->getOrder($branch, $account, $accountGroup);

        // Apply the approved scope to the query builder
        $approvedOrdersQuery = $query->approved()->get();

        // Fetch the IDs of approved orders
        $order = $approvedOrdersQuery->pluck('id');
        // $paid = PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch());
        $paid = PaymentRecord::whereIn('order_id', $order);
        $paid = $paid->whereBetween('created_at', [$startDate, $endDate])->get();
        $totalpaid = $paid->groupBy('created_at')->map(function ($group) {
            return $group->sum('amount');
        });

        $ordersCountChart = $this->processChartDataRevenue($totalpaid, $startDate, $endDate, $interval);

        return $ordersCountChart;
    }
    private function processChartDataRevenue($data, $startDate, $endDate, $interval)
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
    public function getLatestKpiTargetAmountByMonth($account)
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        if (!$account) {
            $accounts = Account::byBranch(\App\Library\Branch::getCurrentBranch())->get();
            $amount = 0;
            
            foreach ($accounts as $account) {
                // $amount += $account->kpiTarget()->month()->latest()->value('amount') ;
        
                $amount += $account->calculateTotalKPI($startDate, $endDate);

            }
        }
        else {
            
    
            $amount = $account->calculateTotalKPI($startDate, $endDate);
            // $amount = $account->kpiTarget()->month()->latest()->value('amount'); 
        }
        return $amount;
    }
  
    public function getLatestKpiTargetAmountByQuater($account, $accountGroup)
    {
        if (!$account) {
            $accounts = Account::byBranch(\App\Library\Branch::getCurrentBranch())->get();
            $amount = 0;
            foreach ($accounts as $account) {
            
                $amount += $account->kpiTarget()->quarter()->latest()->value('amount') ;
            }
        }
        else {
            $amount = $account->kpiTarget()->quarter()->latest()->value('amount');
        } 
        return $amount;
    }

    public function getTotalKPIRevenueOrderThisMonth($branch, $account, $accountGroup)
    {
       
        $orders = $this->getOrder($branch, $account, $accountGroup) ->pluck('id');
    
        $total = PaymentRecord::whereIn('order_id', $orders)
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)->received()->paid()
            ->sum('amount');
        
        return $total;
    }
   
    public function getTotalKPIRevenueOrderThisQuarter($branch, $account, $accountGroup)
    {
        $orders = $this->getOrder($branch, $account, $accountGroup)->pluck('id');
    
        $total = PaymentRecord::whereIn('order_id', $orders)
            ->whereYear('payment_date', now()->year)
            ->where(function ($query) {
                $query->whereBetween('payment_date', [
                    now()->startOfQuarter(),
                    now()->endOfQuarter()
                ]);
            })
            ->received()->paid()
            ->sum('amount');
    
        return $total;
    }

    public function getOrder($branch, $account, $accountGroup)
    {
        $currentBranch = \App\Library\Branch::getCurrentBranch();
        if ($accountGroup && isset($accountGroup->manager)) {
            $query = Order::whereHas('salesperson', function($subQuery) use ($accountGroup) {
                $subQuery->where('account_group_id', $accountGroup->id);
            });
            
        } elseif ($account) {
            
            $query = $account->saleOrders();
        } else {
            $query = Order::byBranch($currentBranch);
        }
        if ($branch) {
            switch ($branch) {
                case Branch::BRANCH_HN:
                case Branch::BRANCH_SG:
                    $query = Order::byBranch($branch);
                    
                    break;
                case 'all':
                    $query = Order::query(); 
                    break;
                default:
                    throw new \Exception('Invalid status:' . $branch);
            }
        }
        return $query;
    }

    public function getContactRequest($branch, $account, $accountGroup)
    {
        $currentBranch = \App\Library\Branch::getCurrentBranch();
        
        if ($accountGroup && isset($accountGroup->manager)) { 
            
            $query = ContactRequest::whereHas('account', function($query) use ($accountGroup) {
                $query->where('account_group_id', $accountGroup->id);
            });
        } elseif ($account) {
            $query = $account->contactRequests();
        } else {
            $query = ContactRequest::byBranch($currentBranch);
        }
        if ($branch) {
            switch ($branch) {
                case Branch::BRANCH_HN:
                case Branch::BRANCH_SG:
                    $query = ContactRequest::byBranch($branch);
                    break;
                case 'all':
                    $query = ContactRequest::isAssigned(); 
                    break;
                default:
                    throw new \Exception('Invalid branch:' . $branch);
            }
        }
        return $query;
    }
   
    // Đơn hàng mới trong tháng
    public function getNewContactRequestThisMonthCount($branch, $account, $accountGroup)
    {
        $contacRequests = $this->getContactRequest($branch, $account, $accountGroup);
        return $contacRequests->isAssigned()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    // Đơn hàng chưa được xử lý
    public function getNoActionContactRequestCount($account,$accountGroup)
    {
        if (!$account) {
            $contactRequests = ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch());;
        } else {
            $contactRequests = $account->contactRequestsByAccount();
        }

        if ($accountGroup) {
            $contactRequests = ContactRequest::whereHas('account', function($query) use ($accountGroup) {
                $query->where('account_group_id', $accountGroup->id);
            }); 
        } 

        return $contactRequests->noActionYet()
            ->count();
    }

    // Công nợ quá hạn
    public static function getOverDueRemindersCount($account, $accountGroup)
    {
        $currentBranch = \App\Library\Branch::getCurrentBranch();

        $query = PaymentReminder::byOrderBranch($currentBranch)
                    ->approved()
                    ->overDueDate();

        if ($account) { 
            $query->whereHas('order.salesperson', function($subQuery) use ($account) {
                $subQuery->where('id', $account->id);
            });
        }

        if ($accountGroup) { 
            $query->whereHas('order.salesperson', function($subQuery) use ($accountGroup) {
                $subQuery->where('account_group_id', $accountGroup->id);
            });
        }

        $paidReminders = $query->get()->filter(function ($paymentReminder) {
            return $paymentReminder->getStatusProgress() === PaymentReminder::STATUS_UNPAID;
        });

        return $paidReminders->count();
    }
    
    // Công nợ sắp tới trong tháng
    public static function getReachingDueDateRemindersCount($account, $accountGroup)
    {
        $currentBranch = \App\Library\Branch::getCurrentBranch();

        $query = PaymentReminder::byOrderBranch($currentBranch)
                    ->approved()
                    ->reachingDueDate();

                    
        if ($account) { 
            $query->whereHas('order.salesperson', function($subQuery) use ($account) {
                $subQuery->where('id', $account->id);
            });
        }

        if ($accountGroup) { 
            $query->whereHas('order.salesperson', function($subQuery) use ($accountGroup) {
                $subQuery->where('account_group_id', $accountGroup->id);
            });
        }

        $paidReminders = $query->get()->filter(function ($paymentReminder) {
            return $paymentReminder->getStatusProgress() === PaymentReminder::STATUS_UNPAID;
        });

        return $paidReminders->count();
    }

    // Dự thu quá hạn
    public static function getAccountKpiNoteOutDateCount($account, $accountGroup)
    {
        $currentBranch = \App\Library\Branch::getCurrentBranch();
        if (!$account) {
            $query = AccountKpiNote::byBranch($currentBranch);
        } 
        elseif ($accountGroup) {
            $query = AccountKpiNote::byBranch($currentBranch)
                ->whereHas('account', function ($subquery) use ($accountGroup) {
                    $subquery->where('account_group_id', $accountGroup->id);
                });
        } else {
            $query = $account->accountKpiNotes()->byBranch($currentBranch);
        } 
        
        return $query->count(); 
    }

    //Hợp đồng
    public function getOrderThisMonthCount($branch, $account, $accountGroup)
    { 
        $query = $this->getOrder($branch, $account, $accountGroup);
        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }
    public function getDraftOrderCount($branch, $account, $accountGroup)
    { 
        $query = $this->getOrder($branch, $account, $accountGroup);
        return $query->draft()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }
    public function getPendingOrderCount($branch, $account, $accountGroup)
    {
        $query = $this->getOrder($branch, $account, $accountGroup);

        return $query->pending()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getActiveOrderCount($branch, $account, $accountGroup)
    {
        $query = $this->getOrder($branch, $account, $accountGroup);

        return $query->approved()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getRejectedOrderCount($branch, $account, $accountGroup)
    {
        $query = $this->getOrder($branch, $account, $accountGroup);

        return $query->rejected()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    // Tỷ lệ loại hợp đồng trong tháng này
    private function getTypesCounts($branch,  $account, $accountGroup,$types)
    {
        $typesCount = []; 
        foreach ($types as $type) {  
            $count = $this->getOrder($branch, $account, $accountGroup)
                ->where('type', $type)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)
                ->count();
                $typesCount[$type] = $count;
        } 
        return $typesCount;
    }

    public function getNewCustomerThisMonthCount($account)
    {
        if (!$account) {
            $query = Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isCustomer();
        } else {
            $query = $account->customers();
        }

        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getRequestDemoCount($account)
    {
        if (!$account) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch())->getRequestDemo();
        } else {
            $query = $account->saleOrders()->getRequestDemo();
        }

        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getNewContractThisMonthCount($account)
    {
        if (!$account) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch());
        } else {
            $query = $account->saleOrders();
        }

        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    //KPI 
    public function getOrderByAccoutCount($branch, $account, $accountGroup)
    {
        return $this->getOrder($branch, $account, $accountGroup)->count();
    }
    
    public function updateInterval(Request $request, $interval)
    {
        $branch=$request->branch;
        $account = Account::find($request->account_id); 
        $accountGroup = AccountGroup::find($request->account_group_id); 
        $endDate = Carbon::now()->endOfDay();
        $dateRange = $this->getDateRangeForInterval($request, $interval, $endDate);
        
        // $branch = $request->query('branch');
        
        $contactRequestCountChart = $this->getContactRequestCountsChart($branch, $account, $accountGroup, $dateRange['startDate'], $dateRange['endDate'], $interval  );
        $ordersCountChart = $this->getOrdersCountsChart($branch, $account, $accountGroup, $dateRange['startDate'], $dateRange['endDate'], $interval);


        $cacheTotalChart = $this->getCacheTotalChart($branch, $account, $accountGroup, $dateRange['startDate'], $dateRange['endDate'], $interval);
        $paidChart = $this->getPaidChart($branch, $account, $accountGroup, $dateRange['startDate'], $dateRange['endDate'], $interval);
        $data = [
            'xAxisData' => array_keys($ordersCountChart), 
            'contactRequestCountChart' => array_values($contactRequestCountChart),
            'ordersCountChart' => array_values($ordersCountChart),

            'xAxisDataOfPayment' => array_keys($paidChart),
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
        
        foreach ($data as $item) {
            if ($interval === 'month') {
                $day = $item->created_at->format('j');
            } elseif ($interval === 'year') {
                $day = $item->created_at->format('M');
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
                $day = $item->created_at->format('d');
            } else {
                $day = $item->created_at->format('D');
                if($day === 'Mon') $day = 'Thứ 2';
                if($day === 'Tue') $day = 'Thứ 3';
                if($day === 'Wed') $day = 'Thứ 4';
                if($day === 'Thu') $day = 'Thứ 5';
                if($day === 'Fri') $day = 'Thứ 6';
                if($day === 'Sat') $day = 'Thứ 7';
                if($day === 'Sun') $day = 'CN';
            }

            if (array_key_exists($day, $chartData)) {
                $chartData[$day]++;
            }
        }

        return $chartData;
    }

    private function getContactRequestCountsChart($branch, $account, $accountGroup, $startDate, $endDate, $interval)
    {  
        $contactRequests=  $this->getContactRequest($branch, $account, $accountGroup);
        $contactRequests = $contactRequests
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get();

        $contactCountChart = $this->processChartData($contactRequests, $startDate, $endDate, $interval);

        return $contactCountChart;
    }

    private function getOrdersCountsChart($branch, $account, $accountGroup, $startDate, $endDate, $interval)
    {
        $orders = $this->getOrder($branch, $account, $accountGroup);
        $orders = $orders->whereBetween('created_at', [$startDate, $endDate])->get();
        $ordersCountChart = $this->processChartData($orders, $startDate, $endDate, $interval);

        return $ordersCountChart;
    }
 
    // Tình trạng xử lý đơn hàng
    private function getLeadStatusCounts($branch, $account, $accountGroup, $leadStatus)
    {
        $leadStatusesCount = [];
        
        foreach ($leadStatus as $status) {
            $query=  $this->getContactRequest($branch, $account, $accountGroup);
            $count = $query->where('lead_status', $status) ->count();
            $leadStatusesCount[$status] = $count;
        }

        return $leadStatusesCount;
    }
}
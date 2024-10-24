<?php

namespace App\Http\Controllers\Sales\Report;

use App\Http\Controllers\Controller;
use App\Models\AccountGroup;
use App\Models\AccountKpiNote;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Library\Permission;

class RevenueReportController extends Controller
{
    public function index(){
        return view('sales.report.revenue_report.index');
    }

    public function list(Request $request){
        if ($request->user()->hasPermission(Permission::SALES_REPORT_ALL)) {
            $query = Order::byBranch(\App\Library\Branch::getCurrentBranch());

            if ($request->account_ids) {
                $query = $query->whereIn('sale', $request->account_ids);
            }
        } else {
            // Chỉ lấy báo cáo của current user
            $query = $request->user()->account->saleOrders();
        }
        $accountGroups = AccountGroup::byBranch(\App\Library\Branch::getCurrentBranch());
        //
        
        
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $accountKpiNote = new AccountKpiNote();
            $weeksInRange = $accountKpiNote->getWeeksInRange($updated_at_from, $updated_at_to);
            
            // $accountKpiNotes = $accountKpiNotes->inTimeRange($request->updated_at_from, $request->updated_at_to);
            
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $accountGroups = $accountGroups->orderBy($sortColumn, $sortDirection);

        $accountGroups = $accountGroups->paginate($request->per_page ?? 10);

        return view('sales.report.revenue_report.list', [
            'accountGroups' => $accountGroups,
            'start' => isset($updated_at_from) ? $updated_at_from : null,
            'end' => isset($updated_at_to) ? $updated_at_to : null,
            'weeksInRange' => isset($weeksInRange) ? $weeksInRange : null,
            
        ]);
    }
    
}

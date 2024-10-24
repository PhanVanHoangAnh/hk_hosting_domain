<?php

namespace App\Http\Controllers\System;

use App\Models\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demand;

class DemandController extends Controller
{
    public function index(Request $request)
    {
        $listViewName = 'demand';
        
        $columns = [
            ['id' => 'name', 'title' => trans('messages.demand.name'), 'title' => trans('messages.demand.name'), 'checked' => true],
            ['id' => 'creator_id', 'title' => trans('messages.demand.creator_id'), 'title' => trans('messages.demand.creator_id'), 'checked' => true],
            ['id' => 'status', 'title' => trans('messages.demand.status'), 'title' => trans('messages.demand.status'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.demand.created_at'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.demand.updated_at'), 'checked' => true],
        ];

        // list view name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        return view('system.demands.index',[
            'listViewName' => $listViewName,
            'status' => $request->status,
            'columns' => $columns,
        ]);
    }

    public function list(Request $request)
    {
        
        $demands = Demand::query();
       
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // // Filter by status
        // $demands->where('status', 'active');
        
        // keyword
        if ($request->keyword) {
            $demands = $demands->search($request->keyword);
        }
        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $demands = $demands->filterByCreatedAt($created_at_from, $created_at_to);
        }

        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $demands = $demands->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // account _ids
        if ($request->account_ids) {
            $demands = $demands->byAccountIds($request->account_ids);
        }

        if($request->status) {
            $demands = $demands->filterByStatuses($request->status);
        }
        

        // statuses
        // if ($request->status) {
        //     switch ($request->status) {
        //         case Demand::STATUS_ACTIVE:
        //             $demands = $demands->draft();
        //             break;

        //         case Demand::STATUS_DELETED:
        //             $demands = $demands->deleted();
        //             break;
        //         case 'all':
        //             break;

        //         default:
        //             throw new \Exception('Invalid status:' . $request->status);
        //     }
        // }



        // sort
        $demands = $demands->orderBy($sortColumn, $sortDirection);

        // pagination
        $demands = $demands->paginate($request->per_page ?? '20');
        return view('system.demands.list', [
            'demands' => $demands,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        $demandName = $request->name;
        $demand = Demand::newDefault($demandName);
        return view('system.demands.create',[
            'demand' => $demand,
        ]);
    }

    public function store(Request $request)
    {
        $demandName = $request->name;
        $demand = Demand::newDefault($demandName);
        $errors = $demand->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.demands.create', [
                'demand' => $demand,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới đơn hàng thành công!'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $demand = Demand::find($id);
        return view('system.demands.edit', [
            'demand' => $demand,
        ]);
    }

    public function update(Request $request, $id)
    {
        $demand = Demand::find($id);
        $errors = $demand->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.demands.edit', [
                'demand' => $demand,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
           'status' =>'success',
           'message' => 'Cập nhật đơn hàng thành công!'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $demand = Demand::find($id);
        $demand->deleteDemand();

        return response()->json([
           'status' =>'success',
           'message' => 'Xóa đơn hàng thành công!'
        ]);
    }

    public function destroyAll(Request $request)
    {
        if (!empty($request->ids)) {
            Demand::deleteListDemand(($request->ids));
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa đơn hàng thành công!'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không có đơn hàng nào để xóa!'
        ], 400);
    }
    
}

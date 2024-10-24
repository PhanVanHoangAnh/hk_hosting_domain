<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StaffGroup;

class StaffGroupController extends Controller
{
    public function index(Request $request)
    {
        return view('system.staff_groups.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.staff_groups.name'), 'checked' => true],
                ['id' => 'group_manager_id', 'title' => trans('messages.staff_groups.group_manager_id'), 'checked' => true],
                ['id' => 'type', 'title' => trans('messages.staff_groups.type'), 'checked' => true],
                ['id' => 'default_payment_account_id', 'title' => trans('messages.staff_groups.default_payment_account_id'), 'checked' => true],
            ]
        ]);
    }

    public function list(Request $request)
    {
        $query = StaffGroup::query();

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if($request->staffTypes) {
            $query = $query->filterByTypes($request->staffTypes);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }
        
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $staffGroups = $query->paginate($request->perpage ?? 10);

        return view('system.staff_groups.list', [
            'staffGroups' => $staffGroups,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        return view('system.staff_groups.create');
    }

    public function store(Request $request)
    {
        $staffGroup = StaffGroup::newDefault();
        $errors = $staffGroup->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.staff_groups.create', [
                'errors' => $errors,
                'staffGroup' => $staffGroup
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo mới nhóm nhân sự thành công!'
        ]);
    }

    public function destroy(Request $request)
    {
        $staffGroup = StaffGroup::find($request->id);

        $staffGroup->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa nhóm nhân viên thành công!"
        ]);
    }

    public function deleteAll(Request $request) 
    {
        if(!empty($request->items)) {

            StaffGroup::deleteAll($request->items);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công các nhóm!'
            ], 200); 
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Không tìm thấy các nhóm!'
        ], 400);
    }

    public function edit(Request $request, $id)
    {
        $staffGroup = StaffGroup::find($id);

        return view('system.staff_groups.edit', [
            'staffGroup' => $staffGroup,
        ]);
    }

    public function update(Request $request, $id)
    {
        $staffGroup = StaffGroup::find($id);
        $errors = $staffGroup->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.staff_groups.edit', [
                'staffGroup' => $staffGroup,
                'errors' => $errors,
            ], 400);
        }

        $staffGroup->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Chật nhóm nhân sự thành công',
        ]);
    }
}

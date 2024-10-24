<?php

namespace App\Http\Controllers\System;

use App\Models\AccountGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AccountGroupController extends Controller
{
    public function index()
    {
        return view('system.account_groups.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.account_group.name'), 'checked' => true],
                ['id' => 'type', 'title' => trans('messages.account_groups.type'), 'checked' => true],
                ['id' => 'manager', 'title' => trans('messages.account_groups.manager'), 'checked' => true],
                ['id' => 'members', 'title' => trans('messages.account_groups.members'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.account_group.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.account_group.updated_at'), 'checked' => true],
            ]
        ]);
    }

    public function list(Request $request)
    {
        $accountGroups = AccountGroup::query();
        if ($request->keyword) {
            $accountGroups = $accountGroups->search($request->keyword);
        }

        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $accountGroups = $accountGroups->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $accountGroups = $accountGroups->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // sort
        $accountGroups = $accountGroups->orderBy($sortColumn, $sortDirection);

        //pagination
        $accountGroups = $accountGroups->paginate($request->perpage ?? 10);

        return view('system.account_groups.list', [
            'accountGroups' => $accountGroups,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        $accountGroup = AccountGroup::newDefault();
        return view('system.account_groups.create', [
            'accountGroup' => $accountGroup,
        ]);
    }

    public function store(Request $request)
    {
        $accountGroup = AccountGroup::newDefault();
        $errors = $accountGroup->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.account_groups.create', [
                'accountGroup' => $accountGroup,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm nhóm tài khoản thành công',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $accountGroup = AccountGroup::find($id);
        $accountGroup->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa nhóm tài khoản thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $accountGroup = AccountGroup::find($id);
        return view('system.account_groups.edit', [
            'accountGroup' => $accountGroup,
        ]);
    }

    public function update(Request $request, $id)
    {
        $accountGroup = AccountGroup::find($id);
        $errors = $accountGroup->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('system.account_groups.edit', [
                'accountGroup' => $accountGroup,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã chỉnh sửa nhóm tài khoản thành công',
        ]);
    }

    public function deleteAccountGroups(Request $request)
    {
        //
        $accountGroupIds = $request->input('account_group_ids');
        //
        $accountGroups = AccountGroup::whereIn('id', $accountGroupIds)->get();
        return view('system.account_groups.deleteAccountGroups', [
            'accountGroups' => $accountGroups,
        ]);
    }

    public function actionDeleteAccountGroups(Request $request)
    {
        // Lấy danh sách các ID từ trường 'account_group_ids' trong request
        $accountGroupIds = $request->input('account_group_ids');
        // Sử dụng danh sách các ID để lấy các account tương ứng
        AccountGroup::whereIn('id', $accountGroupIds)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa account khách hàng thành công',
        ]);
    }

    public function select2(Request $request)
    {
        return response()->json(AccountGroup::select2($request));
    }
}
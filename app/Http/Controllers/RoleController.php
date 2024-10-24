<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index', [
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.role.name'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.role.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.role.updated_at'), 'checked' => true],
            ]
        ]);
    }
    public function list(Request $request)
    {
        // init
        $roles = Role::with('accounts');
        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // keyword
        if ($request->keyword) {
            $roles = $roles->search($request->keyword);
        }


        // sort
        $roles = $roles->orderBy($sortColumn, $sortDirection);
        // pagination
        $roles = $roles->paginate(10);

        return view('roles.list', [
            'roles' => $roles,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,

        ]);
    }

    public function create(Request $request)
    {
        // init
        // $role = Role::newDefault();
        $role = $request->user()->account->newRole();

        //
        return view('roles.create', [
            'role' => $role,
        ]);
    }

    public function store(Request $request)
    {
        $role = $request->user()->account->newRole();
        // init
        // $role = Role::newDefault();

        // validate
        $errors = $role->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('roles.create', [
                'role' => $role,
                'errors' => $errors,
            ], 400);
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm role thành công',
        ]);
    }
    public function update(Request $request, $id)
    {

        // init
        $role = Role::find($id);

        // validate
        $errors = $role->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('roles.edit', [
                'role' => $role,
                'errors' => $errors,
            ], 400);
        }

        $role->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã chỉnh sửa role thành công',
        ]);
    }
    public function edit(Request $request, $id)
    {
        // init
        $role = Role::find($id);

        //
        return view('roles.edit', [
            'role' => $role,
        ]);
    }
    public function destroy(Request $request, $id)
    {
        // init
        $role = Role::find($id);

        // delete
        // $role->delete();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa role thành công',
        ]);
    }
}

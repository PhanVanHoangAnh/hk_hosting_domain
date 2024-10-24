<?php

namespace App\Http\Controllers;

use App\Models\Account;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('accounts.index', [
            'columns' => [
                ['id' => 'code', 'title' => trans('messages.account.code'), 'checked' => true],
                ['id' => 'name', 'title' => trans('messages.account.name'), 'checked' => true],
                ['id' => 'account_group_id', 'title' => trans('messages.account.account_group_id'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.account.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.account.updated_at'), 'checked' => true],
            ]
        ]);
    }
    public function list(Request $request)
    {
        $accounts = Account::query();
        if ($request->keyword) {
            $accounts = $accounts->search($request->keyword);
        }

        $sortColumn = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        // Filter by created_at
        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $accounts = $accounts->filterByCreatedAt($created_at_from, $created_at_to);
        }
        // Filter by updated_at
        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $accounts = $accounts->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        // sort
        $accounts = $accounts->orderBy($sortColumn, $sortDirection);

        //pagination
        $accounts = $accounts->paginate($request->perpage ?? 5);

        return view('accounts.list', [
            'accounts' => $accounts,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        $account = Account::newDefault();
        return view('accounts.create', [
            'accounts' => $account,
        ]);
    }

    public function store(Request $request)
    {
        $account = Account::newDefault();
        $errors = $account->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounts.create', [
                'account' => $account,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm account thành công',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $account = Account::find($id);
        // $account->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa khách hàng thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $account = Account::find($id);
        return view('accounts.edit', [
            'account' => $account,
        ]);
    }

    public function update(Request $request, $id)
    {
        $account = Account::find($id);
        $errors = $account->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounts.edit', [
                'account' => $account,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm account thành công',
        ]);
    }

    public function deleteAccounts(Request $request)
    {
        $accountIds = $request->input('account_ids');
        $accounts = Account::whereIn('id', $accountIds)->get();

        return view('accounts.deleteAccounts', [
            'accounts' => $accounts,
        ]);
    }

    public function actionDeleteAccounts(Request $request)
    {
        // Lấy danh sách các ID từ trường 'account_ids' trong request
        $accountIds = $request->input('account_ids');
        // Sử dụng danh sách các ID để lấy các account tương ứng
        // Account::whereIn('id', $accountIds)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa account khách hàng thành công',
        ]);
    }

    public function select2(Request $request)
    {
        return response()->json(Account::select2($request));
    }
    

    public function getSaleSupBySale(Request $request) 
    {
        $sale = Account::find($request->id);

        if (!$sale) {
            throw new \Exception("Sale not found!");
        }

        $saleSup = $sale->getSaleSup();

        return response()->json([
            'status' => 'success',
            'saleSup' => $saleSup
        ], 200);
    }
    public function selectHK(Request $request)
    {
        return response()->json(Account::selectHK($request));
    }
}

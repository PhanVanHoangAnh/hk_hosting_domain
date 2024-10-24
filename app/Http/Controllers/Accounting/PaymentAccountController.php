<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\AccountGroup;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    public function index(Request $request)
    {
        return view('accounting.payment_accounts.index', [
            'status' => $request->status,
        ]);
    }

    public function list(Request $request){
        
        $paymentAccounts = PaymentAccount::query();

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        if ($request->keyword) {
            $paymentAccounts = $paymentAccounts->search($request->keyword);
        }


        // statuses
        if($request->status) {
            switch ($request->status) {
        
                case PaymentAccount::STATUS_INACTIVE:
                    $paymentAccounts = $paymentAccounts->inactive();
                    break;

                case PaymentAccount::STATUS_ACTIVE:
                    $paymentAccounts = $paymentAccounts->active();
                    break;
                
                
                case PaymentAccount::STATUS_PAUSE:
                    $paymentAccounts = $paymentAccounts->isPause();
                    break;

                case PaymentAccount::STATUS_DELETED:
                    $paymentAccounts = $paymentAccounts->deleted();
                    break;
                
                case 'all':
                    break;

                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        $paymentAccounts = $paymentAccounts->orderBy($sortColumn, $sortDirection);

        $paymentAccounts = $paymentAccounts->paginate($request->perpage ?? 20);


        
        return view('accounting.payment_accounts.list',[
            'paymentAccounts' => $paymentAccounts,

            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        // init
        $paymentAccount =PaymentAccount ::newDefault();
        $accountGroups = AccountGroup::all();
       
        //
        return view('accounting.payment_accounts.create', [
            'paymentAccount' => $paymentAccount,
            'accountGroups' => $accountGroups,
        ]);
    }


    public function store(Request $request)
    {
        $paymentAccount = PaymentAccount::newDefault();
        // init

        // validate
        $errors = $paymentAccount->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payment_accounts.create', [
                'paymentAccount' => $paymentAccount,
                'errors' => $errors,
            ], 400);
        }

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm tài khoản thành công',
        ]);
    }

    public function edit(Request $request, $id)
    {
        // init
        $paymentAccount = PaymentAccount::find($id);
        $accountGroups = AccountGroup::all();
        //
        return view('accounting.payment_accounts.edit', [
            'paymentAccount' => $paymentAccount,
            'accountGroups' => $accountGroups,
        ]);
    }

    public function update(Request $request, $id)
    {

        // init
        $paymentAccount = PaymentAccount::find($id);

        // validate
        $errors = $paymentAccount->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('accounting.payment_accounts.edit', [
                'paymentAccount' => $paymentAccount,
                'errors' => $errors,
            ], 400);
        }

        $paymentAccount->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Đã chỉnh sửa account thành công',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // init
        $account = PaymentAccount::find($id);

        // delete
        // $account->deletePaymentAccount();
        $account->delete();

        //
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa tài khoản thành công',
        ]);
    }

    public function pausePaymentAccount(Request $request, $id)
    {
        $paymentAccount = PaymentAccount::find($id);

        $paymentAccount->pause();

        return response()->json([
            'status' => 'success',
            'message' => 'Tài khoản đã tạm ngưng',
        ]);
    }
}

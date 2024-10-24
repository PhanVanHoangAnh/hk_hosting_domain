<?php

namespace App\Http\Controllers\Sales;

use App\Events\RequestConfirmReceiptFromSale;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\PaymentAccount;
use App\Models\PaymentRecord;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;

class PaymentRecordController extends Controller
{
    public function storeReceiptContact(Request $request, $id)
    {
        $paymentRecord = PaymentRecord::newDefault();
        
        $order = Order::find($request->id);
        $paymentAccounts = PaymentAccount::all();
        $contact = Contact::find($id);
        
        $errors = $paymentRecord->storeFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.payments.createReceiptContact', [
                'errors' => $errors,
                'contact' => $contact,
                'paymentAccounts'=> $paymentAccounts,
                'order' => $order,
                 
            ], 400);
        }
        
        $paymentRecord->status = PaymentRecord::STATUS_PENDING;
        $paymentRecord->save();

        // event
        RequestConfirmReceiptFromSale::dispatch($paymentRecord);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo phiếu thu thành công!'
        ]);
    }
    
    public function createReceiptContact(Request $request)
    {
        $paymentRecord = $request->user()->account->newDefault();
        
        $order = Order::find($request->id); 
        if ($order->salesperson->accountGroup) {
            switch ($order->type) {
                case Order::TYPE_ABROAD:
                    $paymentAccounts = $order->salesperson->accountGroup->paymentAccountAbroad();
                    break;
                case Order::TYPE_EDU:
                    $paymentAccounts = $order->salesperson->accountGroup->paymentAccountEdu();
                    break;
                case Order::TYPE_EXTRACURRICULAR:
                    $paymentAccounts = $order->salesperson->accountGroup->paymentAccountExtracurricular();
                    break;
                default:
            }
        }
        $schedulePayments = PaymentReminder::where('order_id', $order->id)
        ->get()
        ->sortBy('due_date');

        //
        return view('sales.payments.createReceiptContact', [
            'paymentRecord' => $paymentRecord,
            'order' => $order, 
            'paymentAccounts' => $paymentAccounts,
            'schedulePayments' =>$schedulePayments
        ]);
    }
}

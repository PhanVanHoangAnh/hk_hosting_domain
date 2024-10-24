<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentReminder;
use App\Utilities\Util;
use App\Models\PaymentRecord;

class OnePayController extends Controller
{
    public function onepayPayment($id, $amount){
        $order = Order::find($id);
        // tao 1 phieu thu voi status == pending
        $paymentRecord = $order->createPendingPaymentRecord($amount);
        // Xu ly onepay de tao link payment
        $url  = url('/onepay/process');

        $vpcMerchantTxnRef = "TEST_" . time();
        $merchantParam = [
            "vpc_Version" => "2",
            "vpc_Currency" => "VND",
            "vpc_Command" => "pay",
            "vpc_AccessCode" => env('MERCHANT_PAYNOW_ACCESS_CODE'),
            "vpc_MerchTxnRef" => $vpcMerchantTxnRef,
            "vpc_Merchant" => env('MERCHANT_INSTALLMENT_ID'),
            "vpc_Locale" => "vn",
            "vpc_ReturnURL" => $url ,
            "vpc_OrderInfo" => $paymentRecord->id,
            "vpc_Amount" => $amount*100,
            "vpc_TicketNo" => "192.168.166.149",
            "AgainLink"=> "https://mtf.onepay.vn/client/qt/",
            "Title" => "PHP VPC 3-Party",
            "vpc_Customer_Phone" => "84987654321",
            "vpc_Customer_Email" => "test@onepay.vn",
            "vpc_Customer_Id" => "test"
        ];

        $util = new Util(); 

        ksort($merchantParam);
        
        $stringToHash = $util->generateStringToHash($merchantParam);
        $secureHash = $util->generateSecureHash($stringToHash, env('MERCHANT_PAYNOW_HASH_CODE'));
        
        // Thêm tham số mới
        $merchantParam['vpc_SecureHash'] = $secureHash;
        $requestUrl = env('BASE_URL') . env('URL_PREFIX') . http_build_query($merchantParam);
        $redirectUrl = $util->getRedirectUrl($requestUrl);
        return $redirectUrl;
    }
   
    public function process(Request $request)
    {
        
        if (!$this->checkRequest()) {
            return abort(404);
        }

        // Tao phieu thu
        $paymentRecord = PaymentRecord::find($request->vpc_OrderInfo);
         

        // Da thanh toan roi
        if ($paymentRecord->isPaid()) {
            throw new \Exception('Phieu thu da thanh toan roi');
        }

        if (!$paymentRecord->isPendingOnepay()) {
            throw new \Exception('Phieu thu khong cho thanh toan');
        }

        // set phieu thu thanh toan roi
        if ($paymentRecord->isPendingOnepay()) {
            $paymentRecord->setPending();
        }

        return \Redirect::to('student/payment_reminders')->with('payment_success', true);

    }

    public function checkRequest()
    {
        $url = \Request::getRequestUri();
        $parts = parse_url($url);
        $queriesString = $parts['query'];
        $queriesParamMap = [];
        parse_str($queriesString, $queriesParamMap);
        $merchantHash = $queriesParamMap['vpc_SecureHash'];
        ksort($queriesParamMap);
        $util = new Util();
        $stringToHash = $util->generateStringToHash($queriesParamMap);
        $onePayHash = $util->generateSecureHash($stringToHash, env('MERCHANT_PAYNOW_HASH_CODE'));
        // print_r(nl2br("Merchant's hash: $merchantHash"));
        // print_r(nl2br("OnePay's hash: $onePayHash"));
        if ($merchantHash != $onePayHash) {
            // print_r("Invalid vpc_SecureHash");
            return false;
        } else {
            // print_r("vpc_SecureHash is valid");
            return true;
        }
    }

    public function createReceipt(Request $request, $id)
    {
        $order =  Order::find($id);
        return view('student.onepay.createReceipt', [
            'order' =>$order,
           
            
        ]);
    }
    public function showLink(Request $request)
    {
       $id = $request->id;
       $amount = $request->amount;
       $order = Order::find($id);
       $redirectUrl = $this->onepayPayment($id,$amount );
        return view('student.onepay.showLink', [
            'order' =>$order,
            'redirectUrl'=>$redirectUrl,
        ]);
    }
    
}

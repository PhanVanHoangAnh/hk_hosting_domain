<?php

namespace App\Listeners;

use App\Events\ConfirmReceiptFromSale;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmReceiptFromSaleListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConfirmReceiptFromSale $event): void
    {
        $paymentRecord = $event->paymentRecord;
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();
        $sales = $paymentRecord->order->salesperson;
        
        // notify to accounting
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\ConfirmReceiptFromSaleNotification($paymentRecord));
        }
      

        // notify to user
        foreach ($sales->users as $user) {
            $user->notify(new \App\Notifications\ConfirmReceiptFromSaleNotification($paymentRecord));
        }
       
        //notelog 
        $paymentRecord->contact->addNoteLog($sales, "Nhân viên sale " . $sales->name . " đã tạo phiếu thu " . $paymentRecord->id . " cho hợp đồng " . $paymentRecord->order->code);

    }
}

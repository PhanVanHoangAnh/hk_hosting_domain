<?php

namespace App\Listeners;

use App\Events\RequestConfirmReceiptFromSale;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RequestConfirmReceiptFromSaleListener
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
    public function handle(RequestConfirmReceiptFromSale $event): void
    {
        $paymentRecord = $event->paymentRecord;
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\RequestConfirmReceiptFromSaleNotification($paymentRecord));
        }
    }
}

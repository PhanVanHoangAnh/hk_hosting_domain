<?php

namespace App\Listeners;

use App\Events\OrderApprovalRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class SendOrderApprovalRequestedNotification
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
    public function handle(OrderApprovalRequested $event): void
    {
        $order = $event->order;
        $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();

        // Notify to users(accounting)
        foreach($users as $user) {
            $user->notify(new \App\Notifications\SendOrderApprovalRequestedNotification($order));
        }

        // $saleUsers = \App\Models\User::withPermission(\App\Library\Permission::SALES_REPORT_ALL)->get();
        $saleUsers = $order->salesperson;
        
        // Notify to sales
        foreach($saleUsers->users as $user) {
            $user->notify(new \App\Notifications\SendOrderApprovalRequestedForSaleNotification($order));
        }

        // Add notelog for contact
        $order->contacts->addNoteLog($user->account, "Hợp đồng mã số <strong>{$order->code}</strong> của bạn đang được yêu cầu duyệt.");

        $accounts = Account::where('student_id', $order->contacts->id)->get();

        // Notify to all contact in current contact account
        foreach($accounts as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\SendOrderApprovalRequestedStudentNotification($order));
            }
        }
    }
}

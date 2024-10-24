<?php

namespace App\Listeners;

use App\Events\OrderRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddOrderRejectedContactNoteLog
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
    public function handle(OrderRejected $event): void
    {
        $order = $event->order;
        $account = $order->salesperson;

        // notify to user
        foreach ($account->users as $user) {
            $user->notify(new \App\Notifications\SendOrderRejectedNotification($order));
        }
        
        // update reminders
        $order->contacts->addNoteLog($account, "Hợp đồng mã số <strong>{$order->code}</strong> của bạn không được duyệt. Lý do: " . $order->rejected_reason);
    }
}

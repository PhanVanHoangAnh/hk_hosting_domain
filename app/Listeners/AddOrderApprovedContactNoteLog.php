<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddOrderApprovedContactNoteLog
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
    public function handle(OrderApproved $event): void
    {
        $order = $event->order;
        $account = $event->user->account;

        // notify to user
        foreach ($order->salesperson->users as $user) {
            $user->notify(new \App\Notifications\SendOrderApprovedNotification($order));
        }
        
        // update reminders
        $order->contacts->addNoteLog($account, "Hợp đồng " . trans('messages.order.type.' . $order->type) . " số <strong>{$order->getCode()}</strong>, học viên " . $order->contacts->name . " đã được duyệt.");
    }
}

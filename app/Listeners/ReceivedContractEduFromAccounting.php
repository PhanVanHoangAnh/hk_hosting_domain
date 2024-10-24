<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReceivedContractEduFromAccounting
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
        $users = \App\Models\User::withPermission(\App\Library\Permission::EDU_GENERAL)->get();
        if($order->type === \App\Models\Order::TYPE_EDU){
            foreach($users as $user) {
                $user->notify(new \App\Notifications\ReceivedContractEduFromAccountingNotification($order));
            }
        }
    }
}

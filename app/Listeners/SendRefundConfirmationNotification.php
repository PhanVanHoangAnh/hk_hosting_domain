<?php

namespace App\Listeners;

use App\Events\ConfirmRefundRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRefundConfirmationNotification
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
    public function handle(ConfirmRefundRequest $event): void
    {
        $orderItemIds = $event->orderItemIds;
        $numberOfItems = count($orderItemIds);
        $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();

      
        // Notify to users(accounting)
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendRefundConfirmationNotification($numberOfItems));
        }
      
       
    }
}

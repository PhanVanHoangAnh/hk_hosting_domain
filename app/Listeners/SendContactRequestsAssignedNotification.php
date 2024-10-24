<?php

namespace App\Listeners;

use App\Events\ContactRequestsAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactRequestsAssignedNotification
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
    public function handle(ContactRequestsAssigned $event): void
    {
        $account = $event->account;
        $contactRequests = $event->contactRequests;

        // notify to user
        foreach($account->users as $user) {
            $user->notify(new \App\Notifications\SendContactRequestsAssigned($contactRequests->count()));
        }
    }
}

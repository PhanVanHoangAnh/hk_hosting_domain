<?php

namespace App\Listeners;

use App\Events\SingleContactRequestAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSingleContactRequestAssignedNotification
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
    public function handle(SingleContactRequestAssigned $event): void
    {
        $account = $event->account;
        $contactRequest = $event->contactRequest;

        // notify to user
        foreach($account->users as $user) {
            $user->notify(new \App\Notifications\SingleContactRequestAssigned($contactRequest));
        }
    }
}

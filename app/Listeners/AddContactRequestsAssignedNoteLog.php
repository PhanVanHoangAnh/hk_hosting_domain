<?php

namespace App\Listeners;

use App\Events\ContactRequestsAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddContactRequestsAssignedNoteLog
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
        $user = $event->user;
        $account = $event->account;
        $contactRequests = $event->contactRequests;

        // 
        foreach($contactRequests as $contactRequest) {
            $contactRequest->contact->addNoteLog($user->account, "Được bàn giao cho tài khoản <strong>{$account->name}</strong>");
        }
    }
}

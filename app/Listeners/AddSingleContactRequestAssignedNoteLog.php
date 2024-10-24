<?php

namespace App\Listeners;

use App\Events\SingleContactRequestAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddSingleContactRequestAssignedNoteLog
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
        $user = $event->user;

        $contactRequest->contact->addNoteLog($user->account, "Đơn hàng [{$contactRequest->demand}] được bàn giao cho tài khoản <strong>{$account->name}</strong>");
    }
}

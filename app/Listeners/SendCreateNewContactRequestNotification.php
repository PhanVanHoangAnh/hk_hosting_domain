<?php

namespace App\Listeners;

use App\Events\NewContactRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class SendCreateNewContactRequestNotification
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
    public function handle(NewContactRequestCreated $event): void
    {
        $accounts = Account::where('student_id', $event->contactRequest->contact->id)->get();

        foreach($accounts as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\ContactRequest($event->contactRequest));
            }
        }

        $users = \App\Models\User::withPermission(\App\Library\Permission::SALES_DASHBOARD_ALL)->get();

        foreach($users as $user) {
            $user->notify(new \App\Notifications\ContactRequest($event->contactRequest));
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class SendCreateNewUserNotification
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
    public function handle(NewUserCreated $event): void
    {
        $contact = $event->contact;
        $accounts = Account::where('student_id', $contact->id)->get(); // Collection

        foreach ($accounts as $account) {
            // Send notification to every users per account
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\NewUserCreatedNotification($event->contact));
            }
        }
    }
}

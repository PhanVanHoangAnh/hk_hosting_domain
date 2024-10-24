<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class SendCreateNewOrderNotification
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
    public function handle(NewOrderCreated $event): void
    {
        $accounts = Account::where('student_id', $event->order->contacts->id)->get(); // Array

        foreach($accounts as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\OrderNotification($event->order));
            }
        }
    }
}

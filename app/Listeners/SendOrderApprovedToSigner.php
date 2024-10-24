<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class SendOrderApprovedToSigner
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
        $contact = $event->order->contacts;
        $accounts = \App\Models\Account::where('student_id', $contact->id)->get();

        // foreach($accounts as $account) {
        //     foreach($account->users as $user) {
        //         $user->notify(new \App\Notifications\SendOrderApprovedNottificationToUser($event->order));
        //     }
        // }

        $event->user->notify(new \App\Notifications\SendOrderApprovedNottificationToUser($event->order));
    }
}

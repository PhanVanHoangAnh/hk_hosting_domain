<?php

namespace App\Listeners;

use App\Events\NewContactRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class AddCreateNewContactRequestNotelog
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
        $contact = $event->contactRequest->contact; // Student
        $accounts = Account::where('student_id', $contact->id)->get();

        foreach($accounts as $account) {
            $contact->addNoteLog($account, "Bạn có 1 đơn hàng mới!");
        }
    }
}

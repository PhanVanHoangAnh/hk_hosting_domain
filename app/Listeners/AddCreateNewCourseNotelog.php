<?php

namespace App\Listeners;

use App\Events\NewCourseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddCreateNewCourseNotelog
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
    public function handle(NewCourseCreated $event): void
    {
        $course = $event->course;
        $eduAccounts = Account::whereHas('accountGroup', function ($q) {
            $q->where('type', AccountGroup::GROUP_TYPE_EDU);
        })->get();

        $contacts = new Collection();

        // Send notification to all accounts which have type is edu
        foreach($eduAccounts as $account) {
           $contact = Contact::where('email', $account->email);
           $contacts->push($contact);
        }

        // ...
    }
}

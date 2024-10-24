<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\NewCourseCreated;
use App\Models\Teacher;
use App\Models\Account;
use App\Models\AccountGroup;

class SendCreateNewCourseNotification
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

        // Send notification to all accounts which have type is edu
        foreach($eduAccounts as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\NewCourseCreatedNotification($course));
            }
        }
    }
}

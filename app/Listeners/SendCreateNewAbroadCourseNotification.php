<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\NewAbroadCourseCreated;

use App\Models\Account;

class SendCreateNewAbroadCourseNotification
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
    public function handle(NewAbroadCourseCreated $event): void
    {
        $course = $event->course;
        $orderItem = $course->orderItem;

        if (!$orderItem) {
            throw new \Exception('Order item not found!');
        }

        $accounts = Account::where('student_id', $orderItem->orders->contacts->id)->get(); // Array

        foreach($accounts as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\NewAbroadCourseCreatedNotification($event->course));
            }
        }
    }
}

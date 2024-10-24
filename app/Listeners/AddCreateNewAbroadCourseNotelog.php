<?php

namespace App\Listeners;

use App\Events\NewAbroadCourseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class AddCreateNewAbroadCourseNotelog
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

        $contact = $orderItem->orders->contacts;
        $accounts = Account::where('student_id', $orderItem->orders->contacts->id)->get(); // Array

        foreach($accounts as $account) {
            $contact->addNoteLog($account, 'Lớp du học theo hợp đồng của bạn đã được tạo, mã lớp: ' . $event->course->code);
        }
    }
}

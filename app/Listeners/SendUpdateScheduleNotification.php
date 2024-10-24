<?php

namespace App\Listeners;

use App\Events\UpdateSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateScheduleNotification
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
    public function handle(UpdateSchedule $event): void
    {
        $users=[];
       

       
        $users = $event->course->getUserTeacherAndStudent();
        $user =  $event->user;
        $users[] = $user;
        $course = $event->course;
       
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendUpdateScheduleNotification($course));

        }
      
       
    }
}


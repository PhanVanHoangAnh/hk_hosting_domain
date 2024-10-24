<?php

namespace App\Listeners;

use App\Events\UpdateReschedule;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRescheduleEmail
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
    public function handle(UpdateReschedule $event): void
    {
        $users=[];

        $users = $event->section->getUserTeacherAndStudent();
      
        // // // Notify to users(accounting)
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendRescheduleEmail($event->section, $event->sectionCurrent));

        }

           

      
       
    }
}


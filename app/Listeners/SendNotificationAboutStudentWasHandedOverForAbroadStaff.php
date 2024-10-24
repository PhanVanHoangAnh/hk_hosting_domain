<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\TheStudentWasHandedOverForAbroadStaff;
use App\Models\Contact;

class SendNotificationAboutStudentWasHandedOverForAbroadStaff
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
    public function handle(TheStudentWasHandedOverForAbroadStaff $event): void
    {
        $student = Contact::find($event->abroadApplication->contact_id);
        $staff = $event->staff;

        foreach($staff->users as $user) {
            $user->notify(new \App\Notifications\TheStudentWasHandedForAbroadStaffNotification($student, $staff, $event->abroadApplication));
        }
    }
}

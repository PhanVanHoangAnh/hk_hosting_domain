<?php

namespace App\Listeners;

use App\Events\TheStudentWasHandedOverForExtraStaff;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Contact;

class SendNotificationAboutTheStudentWasHandedOverForExtraStaff
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
    public function handle(TheStudentWasHandedOverForExtraStaff $event): void
    {
        $student = Contact::find($event->abroadApplication->contact_id);
        $staff = $event->staff;

        // foreach($staff->users as $user) {
        //     $user->notify(new \App\Notifications\TheStudentWasHandedOverForExtraStaffNotification($student, $staff, $event->abroadApplication));
        // }
    }
}

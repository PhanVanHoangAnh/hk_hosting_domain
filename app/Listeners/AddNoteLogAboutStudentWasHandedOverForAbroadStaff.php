<?php

namespace App\Listeners;

use App\Events\TheStudentWasHandedOverForAbroadStaff;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Contact;

class AddNoteLogAboutStudentWasHandedOverForAbroadStaff
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

        $student->addNoteLog($staff, "Hợp đồng du học số " . $event->abroadApplication->orderItem->orders->code . ",  ngày " . $event->abroadApplication->orderItem->orders->created_at . "của bạn đã được bàn giao cho cán bộ du học " . $staff->name . " phụ trách");
    }
}

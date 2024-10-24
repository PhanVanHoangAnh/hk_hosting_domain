<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\TheStudentWasHandedOverForExtraStaff;
use App\Models\Contact;

class AddNoteLogAboutStudentWasHandedOverForExtraStaff  
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

        $student->addNoteLog($staff, "Hợp đồng ngoại khóa số " . $event->abroadApplication->orderItem->orders->code . ",  ngày " . $event->abroadApplication->orderItem->orders->created_at . "của bạn đã được bàn giao cho cán bộ du học " . $staff->name . " phụ trách");
    }
}

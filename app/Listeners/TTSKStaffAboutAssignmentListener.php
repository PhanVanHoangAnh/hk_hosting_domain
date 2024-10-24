<?php

namespace App\Listeners;

use App\Events\StudentAssignedToTTSK;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TTSKStaffAboutAssignmentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(StudentAssignedToTTSK $event): void
    {
        $abroadApplication = $event->abroadApplication;
        
        $account2 = $abroadApplication->account2;
        
        $sale = $abroadApplication->orderItem->order->salesperson;
        $accountSale = Account::find($sale->id);

        $student = Account::where('student_id', $abroadApplication->contact->id)->get();

        //student
        foreach($student as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\TTSKStudentAssignmentNotification($abroadApplication));
            }
        }
        //sale
        if ($accountSale) {
            foreach ($accountSale->users as $user) {
                $user->notify(new \App\Notifications\TTSKStudentAssignmentNotification($abroadApplication));
            }
        }
        //staff abroad
       
        foreach($account2->users as $user) {
            $user->notify(new \App\Notifications\TTSKStudentAssignmentNotification($abroadApplication));
        }
        

        
       
    }
}

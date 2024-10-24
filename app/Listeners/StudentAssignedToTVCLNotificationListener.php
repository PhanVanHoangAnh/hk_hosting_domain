<?php

namespace App\Listeners;

use App\Events\StudentAssignedToTVCL;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StudentAssignedToTVCLNotificationListener
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
    public function handle(StudentAssignedToTVCL $event): void
    {
        $abroadApplication = $event->abroadApplication;
        
        $account1 = $abroadApplication->account1;
        
        $sale = $abroadApplication->orderItem->order->salesperson;
        $accountSale = Account::find($sale->id);

        $student = Account::where('student_id', $abroadApplication->contact->id)->get();

        //student
        foreach($student as $account) {
            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\TVCLStudentAssignmentNotification($abroadApplication));
            }
        }
        //sale
        if ($accountSale) {
            foreach ($accountSale->users as $user) {
                $user->notify(new \App\Notifications\TVCLStudentAssignmentNotification($abroadApplication));
            }
        }
        //staff abroad
       
        foreach($account1->users as $user) {
            $user->notify(new \App\Notifications\TVCLStudentAssignmentNotification($abroadApplication));
        }
    }
}

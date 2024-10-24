<?php

namespace App\Listeners;

use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendUpdateExtracurricularPlan
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
    public function handle(object $event): void
    {
        $abroadApplication = $event->LoTrinhHoatDongNgoaiKhoa->abroadApplication;
        
        $student = $abroadApplication->student;
        $accounts = Account::where('student_id', $student->id)->get();

        //student
        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\SendUpdateExtracurricularPlanNotification());
            }
        }
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ABROAD_GENERAL)->get();
        //abroad
        foreach($users as $user) {
            $user->notify(new \App\Notifications\SendUpdateExtracurricularPlanNotification());
        }

        //add note log
        $order = $abroadApplication->getOrder();
        $order->contacts->addNoteLog($user->account, "Lộ trình học thuật chiến lược của bạn đã được cập nhật. Vui lòng click vào đường link để xem chi tiết");
    }
}

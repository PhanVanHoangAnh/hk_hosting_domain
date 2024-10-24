<?php

namespace App\Listeners;

use App\Events\UpdateSocialNetwork;
use App\Models\AbroadApplication;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateSocialNetwork
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
    public function handle(UpdateSocialNetwork $event): void
    {
        $abroadApplication = $event->socialNetwork->abroadApplication;
        
        $student = $abroadApplication->student;
        $accounts = Account::where('student_id', $student->id)->get();

        //student
        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\SendUpdateSocialNetworkNotification($event->socialNetwork));
            }
        }
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ABROAD_GENERAL)->get();
        //abroad
        foreach($users as $user) {
            $user->notify(new \App\Notifications\SendUpdateSocialNetworkNotification($event->socialNetwork));
        }

        //add note log
        $order = $abroadApplication->getOrder();
        $order->contacts->addNoteLog($user->account, "Mạng xã hội và kênh truyền thông của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết");
    }
}

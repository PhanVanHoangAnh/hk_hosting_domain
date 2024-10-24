<?php

namespace App\Listeners;

use App\Events\ApproveHSDT;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApproveHSDTNotification
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
    public function handle(ApproveHSDT $event): void
    {
        $abroadApplication = $event->abroadApplication;
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ABROAD_GENERAL)->get();

        foreach($users as $user) {
                
            $user->notify(new \App\Notifications\ApproveHSDTNotification());
        }
    }
}

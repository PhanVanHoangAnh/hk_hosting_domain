<?php

namespace App\Listeners;

use App\Events\RejectHSDT;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRejectHSDTNotification
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
    public function handle(RejectHSDT $event): void
    {
        $abroadApplication = $event->abroadApplication;
        
        $users = \App\Models\User::withPermission(\App\Library\Permission::ABROAD_GENERAL)->get();

        foreach($users as $user) {
                
            $user->notify(new \App\Notifications\RejectHSDTNotification());
        }
    }
}

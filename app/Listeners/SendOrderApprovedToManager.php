<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Account;
use App\Models\User;

class SendOrderApprovedToManager
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
        // $managers =  $user->isAlias(Role::ALIAS_ABROAD_MANAGER);
        $abroadManagers = User::ByManager(\App\Models\Role::ALIAS_ABROAD_MANAGER)->get();
        foreach($abroadManagers as $manager) {
            $manager->notify(new \App\Notifications\SendOrderApprovedToManagerNotification($event->order));
        }
    }
}

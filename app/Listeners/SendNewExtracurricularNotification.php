<?php

namespace App\Listeners;

use App\Events\NewExtracurricularCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewExtracurricularNotification
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
    public function handle(NewExtracurricularCreated $event): void
    {
        $extracurricular = $event->extracurricular;
        $users = \App\Models\User::withPermission(\App\Library\Permission::EXTRACURRICULAR_GENERAL)->get();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\NewExtracurricularNotification($extracurricular));
        }
    }
}

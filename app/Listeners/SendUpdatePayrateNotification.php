<?php

namespace App\Listeners;

use App\Events\PayrateUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdatePayrateNotification
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
    public function handle(PayrateUpdate $event): void
    {
        $accounts = \App\Models\Account::where('id',$event->user->id)->orWhere('teacher_id',$event->teacher->id)->get();
      
        $users = [];
        foreach ($accounts as $account) {
            $user = \App\Models\User::where('account_id', $account->id)->first();
            if ($user) {
                $users[] = $user;
            }
        }
       

      
        // // Notify to users(accounting)
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\SendUpdatePayrateNotification());
        }
      
       
    }
}


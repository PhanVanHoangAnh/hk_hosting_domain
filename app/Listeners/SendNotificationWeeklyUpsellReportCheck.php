<?php

namespace App\Listeners;

use App\Events\WeeklyUpSellReportCheck;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationWeeklyUpsellReportCheck
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
    public function handle(WeeklyUpSellReportCheck $event): void
    {
        $user = $event->user;

        $user->notify(new \App\Notifications\WeeklyUpsellReportCheckNotification());
    }
}

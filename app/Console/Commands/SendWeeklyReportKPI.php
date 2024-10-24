<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class SendWeeklyReportKPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-weekly-report-kpi:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("KPI Report Weekly");
        $currentDate = Carbon::now();
        $firstDayOfMonth = $currentDate->copy()->startOfMonth();
        $currentWeekOfMonth = ceil($currentDate->day / 7);

        if ($currentWeekOfMonth == 1) {
            // if the current week is the first week of the month, use the last week of the previous month
            $startOfWeek = $currentDate->copy()->subMonth()->endOfMonth()->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $currentDate->copy()->subMonth()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        } else {
            // calculate the week based on the current week of the month
            $startOfWeek = $firstDayOfMonth->addWeeks($currentWeekOfMonth - 2)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
        }
        $users = \App\Models\User::withPermission(\App\Library\Permission::SALES_DASHBOARD_ALL)->get();

        foreach ($users as $user) {  
            $user->notify(new \App\Notifications\WeeklyReportKPINotification($startOfWeek, $endOfWeek)); 
        }

    }
}

<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMonthlyReportKPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-monthly-report-kpi:cron';

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
        info("KPI Report Monthly");

        $previousMonth = Carbon::now()->subMonth();
        $month = $previousMonth->month;
        $year = $previousMonth->year;

        $users = \App\Models\User::withPermission(\App\Library\Permission::SALES_DASHBOARD_ALL)->get();

        foreach ($users as $user) {  
            $user->notify(new \App\Notifications\MonthlyReportKPINotification($month, $year)); 
        }

    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WeeklyKpiCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-kpi-check:cron';

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
        info("Check KPI Weekly");
        $users = \App\Models\User::withPermission(\App\Library\Permission::SALES_CUSTOMER)->get();
        

        foreach ($users as $user) {
            $divideRevenueByKpiTarget = $user->account->divideRevenueByKpiTarget();

            if ($divideRevenueByKpiTarget === true) {
                // Send notification for achieving the KPI 
                $percentage = $user->account->getPercentKpiRevenue(); 
                $user->notify(new \App\Notifications\KpiAchievedNotification($percentage)); 
                
            } elseif ($divideRevenueByKpiTarget === false) {
                // Send notification for not achieving the K
                $user->notify(new \App\Notifications\KpiNotAchievedNotification()); 
             
            }
        }
        

    }
}

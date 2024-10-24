<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Library\Permission;

class WeeklyUpsellReportCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-upsell-report-check:cron';
    public $permission = Permission::SALES_REPORT_ALL;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly upsell report check';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permission = $this->permission;

        $users = User::where(function($q) use ($permission) {
            $q->withPermission($permission);
        })->get();

        foreach($users as $user) {
            \App\Events\WeeklyUpSellReportCheck::dispatch($user);
        }
    }
}

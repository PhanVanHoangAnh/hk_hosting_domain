<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Order;
use App\Models\PaymentReminder;
use Illuminate\Console\Command;

class DebtReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debt_reminders:cron';

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
        info("the payment remiders");
        $reachingDueDate30Days = PaymentReminder::reachingDueDate30DaysNotification()->count();

        $reachingDueDate14Days = PaymentReminder::reachingDueDate14DaysNotification()->count();

        $overDueDate = PaymentReminder::overdueNotification()->count();

        $users = \App\Models\User::withPermission(\App\Library\Permission::ACCOUNTING_GENERAL)->get();
        
        foreach ($users as $user) {
            // Send notification to account
            if ($reachingDueDate30Days) {
                $user->notify(new \App\Notifications\SendReminderReachingDueDate30DaysNotification($reachingDueDate30Days)); 
            }
            if ($reachingDueDate14Days) {
                $user->notify(new \App\Notifications\SendReminderReachingDueDate14DaysNotification($reachingDueDate14Days)); 
            }
            if ($overDueDate) {
                $user->notify(new \App\Notifications\SendReminderOverdueDateNotification($overDueDate)); 
            }
        
        }
        
    }
}

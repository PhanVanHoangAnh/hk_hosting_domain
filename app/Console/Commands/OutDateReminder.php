<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentReminder;

class OutDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment_reminder_out_date:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The payment reminder out date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $outDatePaymentReminders = PaymentReminder::overDueDate()->get();

        foreach($outDatePaymentReminders as $reminder) {
            $order = $reminder->order; 
            $sale = $order->salesperson; // Account
            $contact = $order->contacts;

            if ($sale) {
                // Add notifications
                foreach($sale->users as $user) {
                    $user->notify(new \App\Notifications\PaymentReminderOutDateNotification($reminder));
                }

                // Add note log
                $contact->addNoteLog($sale, "Báo cáo dự thu của hợp đồng " . $order->code . " quá hạn chưa thu được!");
            }

        }
    }
}

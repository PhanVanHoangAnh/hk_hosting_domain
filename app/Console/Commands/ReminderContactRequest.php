<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ContactRequest;
use App\Models\Account;

class ReminderContactRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder-contact-request:cron';

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
        info("the contact request is about to reminder");

        $contactRequests = ContactRequest::reminderUnNotified()->get();

        foreach($contactRequests as $contactRequest) {
            $contact = $contactRequest->contact;
            $account = $contactRequest->account;

            if ($contact) {
                $contact->addNoteLog($account, 'Đơn hàng ' . $contactRequest->code . ' của bạn sắp đến lịch hẹn!');
            }

            // Send notification to sale
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\ReminderContactRequest($contactRequest));
            }
            
            $contactRequest->reminderNotified();

        }
    }
}

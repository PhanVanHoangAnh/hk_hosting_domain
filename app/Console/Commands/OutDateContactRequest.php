<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ContactRequest;
use App\Models\Account;

class OutDateContactRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'out_date_contact_request:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all contact requests that expire in 2 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("the contact request is about to expire");

        $outDateContactRequests = ContactRequest::outdatedUnNotified()->get();

        foreach($outDateContactRequests as $contactRequest) {
            $contact = $contactRequest->contact;
            $accounts = Account::where('student_id', $contact->id)->get();
            $notified = false;
            
            foreach ($accounts as $account) {
                // Add notelog
                if ($contact) {
                    $contact->addNoteLog($account, 'Đơn hàng ' . $contactRequest->code . ' của bạn sắp hết hạn!');

                    if (!$notified) $notified = true;
                }

                // Send notification to customers
                foreach ($account->users as $user) {
                    $user->notify(new \App\Notifications\OutDateContactRequest($contactRequest));

                    if (!$notified) $notified = true;
                }
            }

            if ($notified) {
                $contactRequest->assignOutDateNotified();
            }
        }
    }
}

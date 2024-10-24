<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContactRequest;

class UnfulfillOver2HoursContactRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unfulfill_over_2_hours:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all contact requests overdue by 2 hours but still pending processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("the contact request overdue by 2 hours but still pending processing");
        
        $unfulfillContactRequests = ContactRequest::unfulfilledOver2Hours()->get();

        $map = [];

        foreach($unfulfillContactRequests as $contactRequest) {
            $account = $contactRequest->account;

            foreach ($account->users as $user) {
                if (!isset($map[$user->id])) {
                    $map[$user->id] = [];
                }
                
                $map[$user->id][] = $contactRequest;
            }
        }

        foreach ($map as $userId => $contactRequests) {
            \App\Models\User::find($userId)->notify(new \App\Notifications\UnfulfilledOver2HoursContactRequest($contactRequests));
        }
    }
}

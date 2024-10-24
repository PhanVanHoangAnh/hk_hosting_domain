<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateRequestFromContact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-request-from-contact';

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
        $contactRequests = \App\Models\ContactRequest::whereNull('phone')->orWhere('phone', '')->get();

        foreach ($contactRequests as $contactRequest) {
            $contact = $contactRequest->contact;
            if (!$contactRequest->phone && $contact->phone) {
                $phone = \App\Library\Tool::extractPhoneNumberLegacy($contactRequest->contact->phone);

                echo "{$contactRequest->contact->phone} - {$contactRequest->contact->phone} - {$phone} \n";

                $contactRequest->phone = $phone;
                $contactRequest->save();

                $contact->phone = $phone;
                $contact->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateContactRequestCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-contact-request-code';

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
        $contactRequests = \App\Models\ContactRequest::whereNull('code')->get();

        foreach ($contactRequests as $contactRequest) {
            $contactRequest->generateCode();
            echo "{$contactRequest->code} - {$contactRequest->name} - {$contactRequest->phone} \n";
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateContactCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-contact-code';

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
        $contacts = \App\Models\Contact::whereNull('code')->get();

        foreach ($contacts as $contact) {
            $contact->generateCode();
            echo "{$contact->code} - {$contact->name} - {$contact->phone} \n";
        }
    }
}

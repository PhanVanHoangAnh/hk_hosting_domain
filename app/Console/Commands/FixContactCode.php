<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixContactCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-contact-code';

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
        $contacts = \App\Models\Contact::where('code', 'LIKE', 'HS24%')->where('created_at', '<', \Carbon\Carbon::parse('2024-01-01'))->isNotCustomer()->get();
        
        foreach($contacts as $index => $contact) {
            $oldCode = $contact->code;
            $contact->generateCode(true);

            echo "{$index}/{$contacts->count()} : {$oldCode} -> {$contact->code}\n";
        }
    }
}

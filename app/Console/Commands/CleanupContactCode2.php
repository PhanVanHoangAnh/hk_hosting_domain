<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupContactCode2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-contact-code2';

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
        $codes = \App\Models\Contact::select('code', \DB::raw('count(*) as total'))->groupBy('code')->having('total', '>', 1)->get();

        foreach ($codes as $dup) {
            echo $dup->code . " - " . $dup->total . "\n";

            $contacts = \App\Models\Contact::whereCode($dup->code)->get();
            $contacts->shift();

            foreach ($contacts as $contact) {
                $contact->generateCode(true);
                echo "------- " . $contact->code . " - " . $contact->created_at . "\n";
            }
        }
    }
}

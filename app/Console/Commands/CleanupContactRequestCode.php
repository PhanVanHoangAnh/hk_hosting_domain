<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupContactRequestCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-contact-request-code';

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
        // $contacts = \App\Models\Contact::all();

        // foreach ($contacts as $contact) {
        //     if ($contact->getCode() != $contact->code) {
        //         echo "{$contact->id}: {$contact->getCode()} {$contact->code} \n";
        //     }
        // }

        $dups = \App\Models\ContactRequest::select('code', \DB::raw('count(*) as total'))->groupBy('code')->having('total', '>', 1)->get();

        foreach ($dups as $dup) {
            echo $dup->code . " - " . $dup->total . "\n";

            $crs = \App\Models\ContactRequest::whereCode($dup->code)->get();

            if ($dup->code) {
                $crs->shift();
            }

            foreach ($crs as $cr) {
                $cr->generateCode(true);
                echo "------- " . $cr->code . " - " . $cr->created_at . "\n";
            }
        }
    }
}

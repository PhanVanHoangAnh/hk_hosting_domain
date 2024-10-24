<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupContactDupCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-contact-dup-code';

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
        $dups = \App\Models\Contact::select('code', \DB::raw('count(*) as total'))
            ->groupBy('code')
            ->having('total', '>', 1)
            ->get();

        foreach ($dups as $dup) {
            $contacts = \App\Models\Contact::whereCode($dup->code)->get();

            foreach ($contacts as $contact) {
                if ($contact->orders()->count() == 0) {
                    // clear code
                    $contact->code = null;
                    $contact->save();

                    // update code
                    $contact->generateCode();

                    echo "{$contacts->first()->code} -- {$contact->code} \n";
                }
            }
        }
    }
}

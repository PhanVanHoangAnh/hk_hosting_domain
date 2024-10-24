<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupDupContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-dup-contacts';

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
        $dupContacts = \App\Models\Contact::select('phone', \DB::raw('count(*) as total'))->groupBy('phone')->having('total', '>', 1)->get();
    }
}

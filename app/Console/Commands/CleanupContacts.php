<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;

class CleanupContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup all contacts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cleaner = new \App\Library\ContactCleaner();
        $cleaner->run();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\SingleContactCleaner;

class CleanupSingleContact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-single-contact {id}';

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
        $id = $this->argument('id');

        $cleaner = new \App\Library\SingleContactCleaner($id);
        $cleaner->run();
    }
}

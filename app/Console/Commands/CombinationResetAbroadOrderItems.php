<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CombinationResetAbroadOrderItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:combination-reset-abroad-order-items';

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
        $this->call('app:cleanup-abroad-application');
        $this->call('app:reset-order-item-data');
        $this->call('app:fix-contact-request-id-in-orders');
    }
}

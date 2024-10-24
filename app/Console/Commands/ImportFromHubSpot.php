<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\GoogleSheetImporter;

class ImportFromHubSpot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-hubspot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new contact requests from Excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ids = [
            '1ZWDH7Cc3AreiIrqrzBXUToITSkqvbY1uIa4BOtKR85c', // 150k
            '1T82fxR8QD7Lhn3BD_BUFbXAK-gxD3SfZWNuu27Z1ZWQ', // 128K
        ];

        foreach ($ids as $id) {
            $importer = new \App\Library\GoogleSheetImporter($id);
            $importer->addFrom = \App\Models\Contact::ADDED_FROM_HUBSPOT;
            $importer->dateFormat = 'Y-m-d';
            $importer->log = 'console';
            $importer->setLastImportLine(1);
            $importer->assignSale = true;
            $importer->updateContactRequest = true;
            $importer->run(true);
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\GoogleSheetImporter;

class ImportFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-excel';

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
        $importer = new \App\Library\GoogleSheetImporter('1AZZkegzHfuwJMzGmWtjaCJCxmu_iSiHurFQQtveCBbA');
        $importer->addFrom = \App\Models\Contact::ADDED_FROM_EXCEL;
        $importer->dateFormat = 'Y-m-d';
        $importer->log = 'console';
        $importer->setLastImportLine(1);
        $importer->assignSale = true;
        $importer->updateContactRequest = true;
        $importer->run(true);
    }
}

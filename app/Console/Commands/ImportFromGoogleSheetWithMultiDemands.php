<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\GoogleSheetImporter;

class ImportFromGoogleSheetWithMultiDemands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-google-sheet-with-multi-demands {--console=} {--force=} {--line=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new contact requets from Google Sheet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $console = $this->option('console');
        $force = $this->option('force');
        $line = $this->option('line');

        // Import all google sheets
        // $sheets = GoogleSheetImporter::getAllSheetIds();
        $sheets = [
            [
                'sheet_id' => "1cbkJ8NOOTMsBBhPhe6cVHbpqP2dbiZIHFoUYgF532O4",
                'date_format' => 'Y-m-d',
            ],
        ];

        foreach ($sheets as $sheet) {
            $importer = new \App\Library\GoogleSheetImporter($sheet['sheet_id'], $sheet['date_format']);

            // console
            if ($console == 'true') {
                $importer->log = 'console';
            }

            // // Test only
            if ($line) {
                $importer->setLastImportLine($line);
            }
            // $importer->setLastImportLine(1);
            // $importer->log = 'console';
            // \App\Models\Contact::addedFrom(\App\Models\Contact::ADDED_FROM_GOOGLE_SHEET)->delete();

            // if ($type == 'excel') {
            //     $importer->addFrom = \App\Models\Contact::ADDED_FROM_EXCEL;
            // } else if ($type == 'hubspot') {
            //     bb;
            //     $importer->addFrom = \App\Models\Contact::ADDED_FROM_HUBSPOT;
            // }

            // bàn giao sale
            $importer->assignSale = true;
            $importer->updateContactRequest = true;

            // run
            $importer->run($force == 'true');
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\GoogleSheetImporter;

class UpdateLeadStatusFromGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-lead-status {--console=} {--force=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update lead status from Google Sheet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $console = $this->option('console');
        $force = $this->option('force');

        // Import all google sheets
        $sheets = GoogleSheetImporter::getAllSheetIds();

        foreach ($sheets as $sheet) {
            $importer = new \App\Library\GoogleSheetImporter($sheet['sheet_id'], $sheet['date_format']);

            // console
            if ($console == 'true') {
                $importer->log = 'console';
            }

            // // Test only
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

            // run
            $importer->run($force == 'true');
        }
    }
}

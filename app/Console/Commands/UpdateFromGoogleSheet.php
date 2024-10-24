<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\GoogleSheetImporter;

class UpdateFromGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-from-google-sheet {--console=} {--force=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update contact requets from Google Sheet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $console = $this->option('console');
        $force = $this->option('force');

        // Import all google sheets
        // $sheets = GoogleSheetImporter::getAllSheetIds();
        $sheets = [
            // [
            //     'sheet_id' => "1z4IR144QkUBasB-acE30vNs7nXQV78nGJlUFvAX4BrQ",
            //     'date_format' => 'Y-m-d H:i:s',
            // ],
            [
                'sheet_id' => "1FuXeaWu7StypWYSsduNhfVr90_yZgsJ_gpcm5Eail4c",
                'date_format' => 'Y-m-d',
            ],
        ];

        foreach ($sheets as $sheet) {
            $importer = new \App\Library\GoogleSheetUpdater3($sheet['sheet_id'], $sheet['date_format']);

            // console
            if ($console == 'true') {
                $importer->log = 'console';
            }

            // // Test only
            $importer->setLastImportLine(1);
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

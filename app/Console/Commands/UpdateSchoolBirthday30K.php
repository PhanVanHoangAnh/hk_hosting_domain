<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSchoolBirthday30K extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-school-birthday-30k {--console=} {--force=} {--line=}';

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
        $console = $this->option('console');
        $force = $this->option('force');
        $line = $this->option('line');

        // Import all google sheets
        $sheets = [
            [
                'sheet_id' => "1btz_rschYG2Na5eAEv42mLA-PbdttiUtAHFvc5ewFa8",
                'date_format' => 'Y-m-d',
            ],
            [
                'sheet_id' => "1qwPYkLhxI2YA8JvxZ0iqEgemMMchhLCuVUp14IRJzBM",
                'date_format' => 'Y-m-d',
            ],
        ];

        foreach ($sheets as $sheet) {
            $importer = new \App\Library\ShoolBirthday30KUpdater($sheet['sheet_id'], $sheet['date_format']);

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

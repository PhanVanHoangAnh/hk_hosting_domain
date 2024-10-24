<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-google-sheet {type}';

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
        $type = $this->argument('type');
        
        if ($type == 'excel') {
            // run excel
            $updater = new \App\Library\GoogleSheetUpdater(env('GOOGLE_SHEETS_EXCEL_ID'));
        } else if ($type == 'hubspot') {
            // run excel
            $updater = new \App\Library\GoogleSheetUpdater2('1D0Hkai9YBHo-MANCTM4rj2iLezQpG20ulY1F6qSqfDU');
        } else {
            throw new \Exception("$type is not defined. Accepted types: excel|hubspot");
        }
        
        $updater->run();
    }
}

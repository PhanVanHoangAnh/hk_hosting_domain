<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportToGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-to-google-sheet';

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
        $expoter = new \App\Library\ContactToGoogleSheetExporter('1XtvAs47GFzlQXl2L_XT5iGVywg49l36tb_bymYXlScA');
        $expoter->run();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupNotlogFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-notlog-folders';

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
        $noteLogs = \App\Models\NoteLog::all();

        foreach ($noteLogs as $noteLog) {
            $imagePath = public_path($noteLog->getImagePath());
            $imageDir = public_path($noteLog->getImageDir());

            if (!file_exists($imagePath) && file_exists($imageDir)) {
                if (File::isEmptyDirectory($imageDir)) {
                    File::deleteDirectory($imageDir);

                    echo "$imageDir deleted \n";
                }
            }
        }
    }
}

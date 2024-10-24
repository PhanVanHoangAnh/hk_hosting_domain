<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateNoteLogFromNoteSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-note-log-from-note-sales';

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
        $contactRequests = \App\Models\ContactRequest::where('note_sales', '!=', null)->where('note_sales', '!=', '');

        foreach ($contactRequests->get() as $contactRequest) {
            $noteSales = trim($contactRequest->note_sales);
            if ($noteSales == '') {
                continue;
            }

            $exists = $contactRequest->noteLogs()->where('content', $noteSales);
            
            $exists->delete();
            echo "[{$contactRequest->phone}] : delete : " . $exists->count() . " ====> " . $noteSales  . "\n";

            // if (!$exists->count()) {
            //     echo "Update {$contactRequest->id}"  . "\n\n\n";

            //     $noteLog = $contactRequest->addNoteLog(
            //         $contactRequest->account ?? \App\Models\Account::getDefaultSalesAccount(),
            //         $noteSales,
            //         false
            //     );

            //     $noteLog->created_at = \Carbon\Carbon::parse('2024-04-01');
            //     $noteLog->updated_at = \Carbon\Carbon::parse('2024-04-01');
            //     $noteLog->save();
            // }
        }
    }
}

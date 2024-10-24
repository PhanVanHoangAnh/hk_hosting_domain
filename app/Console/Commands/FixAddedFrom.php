<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixAddedFrom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-added-from';

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
        $service = new \App\Library\GoogleSheetService('1uwq5U3adYZoZIyyEOKKSkQ3CHmCmrDmZJq2YSS4Jjsk');
        $data = $service->readContactSyncSheet('Sheet1!A2:AM300000');

        foreach ($data as $row) {
            $contactRequest = \App\Models\ContactRequest::find($row[0]);
            $addedFrom = $row[1];
            $contactRequest->added_from = $addedFrom;
            $contactRequest->save();

            $contact = $contactRequest->contact;
            $contact->added_from = $addedFrom;
            $contact->save();

            echo "{$contactRequest->id} - {$contactRequest->added_from} \n";
        }
    }
}

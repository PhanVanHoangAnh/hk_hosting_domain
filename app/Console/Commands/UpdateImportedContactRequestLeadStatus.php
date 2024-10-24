<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateImportedContactRequestLeadStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-imported-contact-request-lead-status';

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
        $contactRequests = \App\Models\ContactRequest::whereNotNull('import_id')
            ->whereHas('orders', function ($q) {
                $q->notDeleted()->approved();
            })
            ->get();

        foreach ($contactRequests as $contactRequest) {
            $contactRequest->lead_status = \App\Models\ContactRequest::LS_HAS_CONSTRACT;
            $contactRequest->save();

            echo "SET AS HAS CONSTRACT : {$contactRequest->name} - {$contactRequest->phone} \n";
        }
    }
}

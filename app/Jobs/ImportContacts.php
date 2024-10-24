<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\JobMonitor;
use App\Models\Contact;
use Illuminate\Contracts\Queue\Job;

class ImportContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // init
        $jobMonitor = JobMonitor::createNew(get_class($this), $this->job->getJobId());

        // set init data
        $jobMonitor->updateProgress([
            'status' => 'starting',
            'total' => null,
            'sucess' => null,
            'failed' => null,
        ]);
        
        Contact::importContacts(function ($progressData) use ($jobMonitor) {
            // set init data
            $jobMonitor->updateProgress($progressData);
        });
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Library\ImportContact;
use Illuminate\Support\Facades\Log;


class ImportContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::channel('import')->info('MyJob handle method started');

        try {
            // Your job logic here
            Log::channel('import')->info('Processing the job');

            // Example of a potential error
            // throw new Exception('Something went wrong!');
            ImportContact::importFromFile($this->filePath);

            Log::channel('import')->info('MyJob handle method completed');
        } catch (\Exception $e) {
            Log::channel('import')->error('Error in MyJob handle method', ['error' => $e->getMessage()]);
            // You can also choose to re-throw the exception or handle it accordingly
            // throw $e;
        }
        // ImportContact::importFromFile($this->filePath);
    }
}

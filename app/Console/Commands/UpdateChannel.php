<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-channel';

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
        $contacts = \App\Models\Contact::where('sub_channel', '!=', null)
            ->where('sub_channel', '!=', '')
            ->where('channel', '=', null)
            ->get();

        echo $contacts->count();
    }
}

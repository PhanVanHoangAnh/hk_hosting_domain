<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;



class OverTimeSaveShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'over_time_save_shift:cron';

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
        info("It's over time to save the shift");

        $overTimeSaveShifts = Section::overTimeSaveShift()->get();
        
        echo $overTimeSaveShifts;
    
        foreach($overTimeSaveShifts as $overTimeSaveShift) {
            $course = $overTimeSaveShift->course;

            $users = $overTimeSaveShift->getUser();
          
         
             foreach ($users as $user) {
                
               
                if ($overTimeSaveShift) {
                    // Send notification to customers
                    $user->notify(new \App\Notifications\SendOverTimeSaveShiftNotification($course)); 
                }  
            }

            if ($overTimeSaveShift) {
                $overTimeSaveShift->outdatedOverTimeNotified();
            }
        }
    }
}

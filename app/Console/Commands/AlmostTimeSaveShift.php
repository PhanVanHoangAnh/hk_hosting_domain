<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;



class AlmostTimeSaveShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'almost_time_save_shift:cron';

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
        info("It's almost time to save the shift");

        $almostTimeSaveShifts = Section::almostTimeSaveShift()->get();
        
        echo $almostTimeSaveShifts;
    
        foreach($almostTimeSaveShifts as $almostTimeSaveShift) {
            $course = $almostTimeSaveShift->course;

            $users = $almostTimeSaveShift->getUser();
          
         
             foreach ($users as $user) {
                
               
                if ($almostTimeSaveShift) {
                    // Send notification to customers
                    $user->notify(new \App\Notifications\SendAlmostTimeSaveShiftNotification($course)); 
                }  
            }

            if ($almostTimeSaveShift) {
                $almostTimeSaveShift->outdatedApprovalNotified();
            }
        }
    }
}

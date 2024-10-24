<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\FlyingStudent;
use Illuminate\Console\Command;

class SendAbroadDepartureNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-students-to-study-abroad:cron';

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
        info("Announce when students leave");

        $left14days = FlyingStudent::left14Days()->get();

        $left2days = FlyingStudent::left2Days()->get();

        foreach ($left14days as $item) {
            $abroadApplication = $item->abroadApplication;
            $accounts = Account::where('student_id', $abroadApplication->contact->id)->get(); 

            foreach ($accounts as $account) {
                foreach ($account->users as $user) {
                    $user->notify(new \App\Notifications\FlyingStudent14DaysNotification());
                } 
            }
        }

        foreach ($left2days as $item) {
            $abroadApplication = $item->abroadApplication;
            $accounts = Account::where('student_id', $abroadApplication->contact->id)->get(); 

            foreach ($accounts as $account) {
                foreach ($account->users as $user) {
                    $user->notify(new \App\Notifications\FlyingStudent2DaysNotification());
                } 
            }
            
        }
    }
}

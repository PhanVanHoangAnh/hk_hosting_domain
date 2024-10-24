<?php

namespace App\Listeners;

use App\Events\UpdateStrategicLearningCurriculum;
use App\Models\AbroadApplication;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateStrategicLearningCurriculum
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateStrategicLearningCurriculum $event): void
    {
        $abroadApplicationId = $event->abroadApplication;
        $abroadApplication = AbroadApplication::find($abroadApplicationId->id);
        $contact = $abroadApplication->student;
        $accounts = Account::where('student_id', $contact->id)->get();
        
        foreach ($accounts as $account) {
            foreach ($account->users as $user) {

                $user->notify(new \App\Notifications\UpdateStrategicLearningCurriculumNotification($abroadApplication));
            }

            $abroad = $abroadApplication->getOrder();
            $abroad->contacts->addNoteLog($account, "Lộ trình học thuật chiến lược của bạn đã được cập nhật. Vui lòng click <strong>đây</strong> để xem chi tiết");
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\UpdateCompleteFile;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateCompleteFile
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
    public function handle(UpdateCompleteFile $event): void
    {
        $abroadApplication = $event->abroadApplication;
        $contact = $abroadApplication->student;
        $accounts = Account::where('student_id', $contact->id)->get();

        foreach ($accounts as $account) {
            foreach ($account->users as $user) {

                $user->notify(new \App\Notifications\UpdateStrategicLearningCurriculumNotification($abroadApplication));
            }

            $abroad = $abroadApplication->getOrder();
            $abroad->contacts->addNoteLog($user->account, "Hồ sơ hoàn chỉnh của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết");
        }
    }
}

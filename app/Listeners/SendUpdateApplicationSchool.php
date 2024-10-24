<?php

namespace App\Listeners;

use App\Events\UpdateApplicationSchool;
use App\Models\AbroadApplication;
use App\Models\Account;
use App\Models\ApplicationSchool;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateApplicationSchool
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
    public function handle(UpdateApplicationSchool $event): void
    {
        $applicationSchoolId = $event->applicationSchool->abroadApplication;
        $applicationSchool = AbroadApplication::find($applicationSchoolId->id);
        $contact = $applicationSchool->student;
        $accounts = Account::where('student_id', $contact->id)->get();
        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\UpdateApplicationSchoolNotification($applicationSchool));
            }

            $abroad = $applicationSchool->getOrder();
            $abroad->contacts->addNoteLog($user->account, "Danh sách trường, yêu cầu tuyển sinh của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết");
        }
    }
}

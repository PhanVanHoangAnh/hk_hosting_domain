<?php

namespace App\Listeners;

use App\Events\UpdateCreateCertification;
use App\Models\AbroadApplication;
use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateCreateCertification
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
    public function handle(UpdateCreateCertification $event): void
    {
        $certificationsId = $event->certifications->abroadApplication;
        $certifications = AbroadApplication::find($certificationsId->id);
        $contact = $certifications->student;
        $accounts = Account::where('student_id', $contact->id)->get();

        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\UpdateCreateCertificationNotification($certifications));
            }
        }

        $abroad = $certifications->getOrder();
        // $abroad->contacts->addNoteLog($user->account, "Chứng chỉ của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết");
    }
}

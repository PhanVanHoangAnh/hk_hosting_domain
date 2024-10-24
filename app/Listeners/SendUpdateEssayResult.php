<?php

namespace App\Listeners;

use App\Events\UpdateEssayResult;
use App\Models\AbroadApplication;
use App\Models\Account;
use App\Models\EssayResult;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateEssayResult
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
    public function handle(UpdateEssayResult $event): void
    {
        $essayResultId = $event->essayResult->abroadApplication;
        $essayResult = AbroadApplication::find($essayResultId->id);
        $contact = $essayResult->student;
        $accounts = Account::where('student_id', $contact->id)->get();

        foreach ($accounts as $account) {
            foreach ($account->users as $user) {
                $user->notify(new \App\Notifications\UpdateEssayResultNotification($essayResult));
            }

            $abroad = $essayResult->getOrder();
            $abroad->contacts->addNoteLog($user->account, "Kết quả chấm luận của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết");
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\NewContactRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Account;

class NotificationToAllSalesWhoWorkedWithContact
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
    public function handle(NewContactRequestCreated $event): void
    {
        $contactRequest = $event->contactRequest;
        $contact = $contactRequest->contact;

         // Check if the contact of new contact request had a contact request before and was assigned to this sale again
        // -> notification to this sale
        $salesWorkedWithThisContact = Account::getSalesWorkedWithContact($contact); // accounts

        foreach($salesWorkedWithThisContact as $account) {
            $contact->addNoteLog($account, "Liên hệ/Khách hàng tên: " . $contact->name . ", Số điện thoại: " . $contact->phone . " bạn đã từng làm việc mới có thêm 1 đơn hàng: " . $contactRequest->demand . " , mã đơn hàng: " . $contactRequest->code);

            foreach($account->users as $user) {
                $user->notify(new \App\Notifications\NotificationToSaleAboutContactWorkingWithHaveNewContactRequest($contact, $contactRequest));
            }
        }
    }
}

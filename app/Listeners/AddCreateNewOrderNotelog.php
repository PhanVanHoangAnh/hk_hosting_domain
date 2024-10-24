<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Account;

class AddCreateNewOrderNotelog
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
    public function handle(NewOrderCreated $event): void
    {
        $contact = $event->order->contacts;
        $accounts = Account::where('student_id', $contact->id)->get(); // Array

        foreach($accounts as $account) {
            $contact->addNoteLog($account, "Bạn vừa được tạo thêm 1 hơp đồng " . trans('messages.order.type.' . $event->order->type));
        }
    }
}

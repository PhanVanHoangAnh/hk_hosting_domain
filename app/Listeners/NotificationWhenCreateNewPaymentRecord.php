<?php

namespace App\Listeners;

use App\Events\NewPaymentRecordCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewPaymentRecordMail;
use Illuminate\Support\Facades\Mail;

class NotificationWhenCreateNewPaymentRecord
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
    public function handle(NewPaymentRecordCreated $event): void
    {
        $paymentRecord = $event->paymentRecord;
        $account = $paymentRecord->account;
        $contact = $paymentRecord->contact;
        $order = $paymentRecord->order;

        $contact->addNoteLog($order->salesperson, "Quý khách đã có phiếu thu số " . $paymentRecord->id . ", số tiền " . \App\Helpers\Functions::formatNumber($paymentRecord->amount) . "đ, hợp đồng " . trans('messages.order.type.' . $order->type) . ", mã: " . $order->code . " ngày " . $order->order_date . " với Công ty CPGD American Study");

        // Send email to the user who had assigned constract
        $sendMailUser = $order->contacts;
        $emailToSend = $sendMailUser->email;
        
        if ($emailToSend) {
            Mail::to([
                'email' => $emailToSend
            ])->send(new NewPaymentRecordMail($order, $paymentRecord));
        }

        // Notify to sales
        foreach($account->users as $user) {
            $user->notify(new \App\Notifications\NewPaymentRecordNotificationForSale($paymentRecord));
        }
    }
}

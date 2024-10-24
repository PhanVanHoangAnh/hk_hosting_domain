<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\PaymentRecord;

class NewPaymentRecordNotificationForSale extends Notification
{
    use Queueable;

    public $paymentRecord;

    /**
     * Create a new notification instance.
     */
    public function __construct(PaymentRecord $paymentRecord)
    {
        $this->paymentRecord = $paymentRecord;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $paymentRecord = $this->paymentRecord;
        $order = $paymentRecord->order;

        return [
            'message' => "Quý khách đã có phiếu thu số " . $paymentRecord->id . ", số tiền " . \App\Helpers\Functions::formatNumber($paymentRecord->amount) . "đ, hợp đồng " . trans('messages.order.type.' . $order->type) . ", mã: " . $order->code . " ngày " . $order->order_date . " với Công ty CPGD American Study"
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOrderOutDatedApprovalRequestedNotification extends Notification
{
    use Queueable;
    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $date =  date('d/m/Y', strtotime($this->order->order_date)) ;
        return [
            'message' => "Hợp đồng " . trans('messages.order.type.' . $this->order->type) . "  số <strong>{$this->order->code}</strong> ngày {$date}  của nhân viên tư vấn {$this->order->salesperson->name} đã quá hạn duyệt.",

        ];
    }
}

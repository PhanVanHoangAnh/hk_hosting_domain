<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannel;

use App\Library\Sms;

use App\Models\Order;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['database','mail', SmsChannel::class];
        return ['database', \App\Notifications\Channels\SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view('emails.OrderNotification');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage(),
        ];
    }

    public function toSms(object $notifiable)
    {
        \App\Library\Sms::send(
            $this->getMessage(), // nội dung tin nhắn
            $notifiable->phone // số điện thoại gửi đến. nếu test phone trong .env ko có thí lấy phone của user.
        );
    }

    private function getMessage()
    {
        return 'Bạn có thêm 1 hợp đồng ' . trans('messages.order.type.' . $this->order->type) .
        ' mới với mã là [' . $this->order->code . ']';
    }
}

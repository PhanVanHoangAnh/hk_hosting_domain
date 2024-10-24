<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class SendAssigmentClassNotification extends Notification
{
    use Queueable;
  
    public $orderItem;
    public $course;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderItem,$course)
    {
        $this->orderItem = $orderItem;
        $this->course =$course;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            return (new MailMessage)
                    ->subject('ASMS - Xếp lớp thành công')
                 
                    ->view('emails.AssigmentClass',['course'=>$this->course,'orderItem'=>$this->orderItem]);
        } catch (\Exception $e) {
            Log::error('Email sending failed Error: ' . $e->getMessage());
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Hợp đồng đào tạo <strong>{$this->orderItem->order->code }</strong> đã được xếp lớp thành công.",
        ];
    }
}

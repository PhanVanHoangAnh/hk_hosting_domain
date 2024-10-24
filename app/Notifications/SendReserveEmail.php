<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class SendReserveEmail extends Notification
{
    use Queueable;
  
    public $orderItemIds;
    public $reserveStartAt;
    public $reserveEndAt;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderItemIds,$reserveStartAt,$reserveEndAt)
    {
        $this->orderItemIds = $orderItemIds;
        $this->reserveStartAt =$reserveStartAt;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            $orderItems = OrderItem::whereIn('id', $this->orderItemIds)->get();
            
            return (new MailMessage)
                    ->subject('ASMS - Thông báo bảo lưu')
                 
                    ->view('emails.Reserve',['orderItems'=>$orderItems,'reserveStartAt'=>$this->reserveStartAt, 'reserveEndAt'=>$this->reserveEndAt]);
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
            
        ];
    }
}

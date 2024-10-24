<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestConfirmReceiptFromSaleNotification extends Notification
{
    use Queueable;
    public $paymentRecord;
    /**
     * Create a new notification instance.
     */
    public function __construct($paymentRecord)
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
    public function toArray($notifiable)
    {
        $date =  date('d/m/Y', strtotime($this->paymentRecord->created_at)) ;
        return [
            'message' => "Bạn vừa nhận được 1 yêu cầu duyệt phiếu thu số <strong>{$this->paymentRecord->id}</strong> ngày {$date} học viên {$this->paymentRecord->contact->name} của sale {$this->paymentRecord->order->salesperson->name}",
        ];
    }
    
}

<?php

namespace App\Notifications;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateStrategicLearningCurriculumNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $abroadApplication;
    public function __construct($abroadApplication)
    {
        $this->abroadApplication = $abroadApplication;
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
        
        return [
            'message' => "Lộ trình học thuật chiến lược của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết",
        ];
    }
}

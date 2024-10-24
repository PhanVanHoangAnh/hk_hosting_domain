<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UpdateCreateCertificationNotification extends Notification
{
    use Queueable;
    public $certifications;
    /**
     * Create a new notification instance.
     */
    public function __construct($certifications)
    {
        $this->certifications = $certifications;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            return (new MailMessage)
                    ->subject('ASMS - Chứng chỉ của bạn đã được cập nhật')

                    ->view('emails.updateCreateCertification');
        } catch (\Exception $e) {
            Log::error('Email sending failed  Error: ' . $e->getMessage());
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
            'message' => 'Chứng chỉ của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết',
        ];
    }
}

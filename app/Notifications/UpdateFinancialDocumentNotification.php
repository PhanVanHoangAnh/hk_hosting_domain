<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UpdateFinancialDocumentNotification extends Notification
{
    use Queueable;
    public $abroadApplication;
    /**
     * Create a new notification instance.
     */
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
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            return (new MailMessage)
            ->subject('ASMS - Hồ sơ tài chính của bạn đã được cập nhật')

            ->view('emails.updateFinancialDocument');
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
            'message' => "Hồ sơ tài chính của bạn đã được cập nhật. Vui lòng click vào <strong>đây</strong> để xem chi tiết",
        ];
    }
}

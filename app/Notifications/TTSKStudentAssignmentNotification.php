<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TTSKStudentAssignmentNotification extends Notification
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
        $account = $this->abroadApplication->account2;
        $user = $account->users->first();
        $phone = $user->phone ?? 'không có';
        $email = $user->email ?? 'không có';

        return [
            'message' => "Hồ sơ" . trans('messages.order.type.' . $this->abroadApplication->orderItem->type) ." của học viên {$this->abroadApplication->student->name} đã được bàn giao cho nhân viên ngoại khóa {$account->name}, sđt liên hệ: {$phone}, email: {$email}.",
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\ContactRequest;

class UnfulfilledOver2HoursContactRequest extends Notification
{
    use Queueable;

    public $contactRequests;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $contactRequests)
    {
        $this->contactRequests = $contactRequests;
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
        foreach($this->contactRequests as $contactRequest) {
            $contactRequest->assignUnfulfilledOverHoursNotified();
        }

        return [
            'message' => 'bạn có ' . '[' . count($this->contactRequests) . ']' . ' đơn hàng chưa khai thác'
        ];
    }
}

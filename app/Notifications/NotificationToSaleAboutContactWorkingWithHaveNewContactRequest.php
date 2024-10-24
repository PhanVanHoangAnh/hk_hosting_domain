<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use \App\Models\Contact;
use \App\Models\ContactRequest;

class NotificationToSaleAboutContactWorkingWithHaveNewContactRequest extends Notification
{
    use Queueable;

    public $contact;
    public $contactRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact, ContactRequest $contactRequest)
    {
        $this->contact = $contact;
        $this->contactRequest = $contactRequest;
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
            'message' => "Liên hệ/Khách hàng tên: " . $this->contact->name . ", Số điện thoại: " . $this->contact->phone . " bạn đã từng làm việc mới có thêm 1 đơn hàng: " . $this->contactRequest->demand . " , mã đơn hàng: " . $this->contactRequest->code
        ];
    }
}

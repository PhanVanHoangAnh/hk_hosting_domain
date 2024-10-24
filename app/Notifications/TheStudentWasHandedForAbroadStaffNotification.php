<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Contact;
use App\Models\Account;
use App\Models\AbroadApplication;

class TheStudentWasHandedForAbroadStaffNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $staff;
    public $student;
    public $abroadApplication;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $student, Account $staff, AbroadApplication $abroadApplication)
    {
        $this->student = $student;
        $this->staff = $staff;
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
            'message' => "Học viên " . $this->student->name . ", hợp đồng số " . $this->abroadApplication->orderItem->orders->code . ",  ngày " . $this->abroadApplication->orderItem->orders->created_at . " đã được bàn giao cho cán bộ du học " . $this->staff->name . " phụ trách"
        ];
    }
}

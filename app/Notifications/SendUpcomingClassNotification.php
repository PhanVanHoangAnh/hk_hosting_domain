<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class SendUpcomingClassNotification extends Notification
{

    use Queueable;

    public $course;
    public $section;

    /**
     * Create a new notification instance.
     */
    public function __construct($course,$section)
    {
        $this->course = $course;
        $this->section = $section;
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
                    ->subject("ASMS - Lớp học " . $this->course->code . " sắp tới giờ học")
                 
                    ->view('emails.UpcomingClass',['course'=>$this->course,'section'=>$this->section]);
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
        // $id = $this->course->id;
        // $url = action('App\Http\Controllers\Teacher\CourseController@sections', ['id' => $this->course->id]);
        // Log::info( $url);
        return [
            'message' => "Lớp <strong>{$this->course->code}</strong> sắp đến giờ học.",

        ];
    }
}

;


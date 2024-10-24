<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SendUpdateScheduleNotification extends Notification
{
    use Queueable;
  
    public $course;
    /**
     * Create a new notification instance.
     */
    public function __construct($course)
    {
        $this->course = $course;
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
        // $htmlContent = view('emails.OrderApproved', [
        //     'order' => $this->order
        // ])->render();
    
        // $pdfContent = Pdf::exportPdf($htmlContent);
    
        try {
            return (new MailMessage)
                    ->subject("ASMS - Lớp học " . $this->course->code . " đã thay đổi thời khoá biểu")
                    // ->attachData($pdfContent, 'application.pdf', [
                    //     'mime' => 'application/pdf',
                    // ])
                    ->view('emails.UpdateSchedule',['course'=>$this->course]);
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
            'message' => "Lớp học <strong>{$this->course->code }</strong> đã được thay đổi thời khoá biểu.",
        ];
    }
}

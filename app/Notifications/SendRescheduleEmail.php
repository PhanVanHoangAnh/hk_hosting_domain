<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class SendRescheduleEmail extends Notification
{
    use Queueable;
  
    public $section;
    public $sectionCurrent;
    /**
     * Create a new notification instance.
     */
    public function __construct($section,$sectionCurrent)
    {
        $this->section = $section;
        $this->sectionCurrent =$sectionCurrent;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
       
        try {
           
            
            return (new MailMessage)
                    ->subject('ASMS - Thông báo chuyển buổi của lớp')
                 
                    ->view('emails.Reschedule',['section'=>$this->section,'sectionCurrent'=>$this->sectionCurrent]);
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
            
        ];
    }
}

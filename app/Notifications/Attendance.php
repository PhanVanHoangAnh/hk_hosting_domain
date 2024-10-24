<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class Attendance extends Notification
{
    use Queueable;

    public $studentSection;


    /**
     * Create a new notification instance.
     */
    public function __construct($studentSection)
    {
        $this->studentSection = $studentSection;
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
        $sectionReport = \App\Models\SectionReport::where('student_id', $this->studentSection->student_id)->where('section_id', $this->studentSection->section_id)->first();

        try {
            return (new MailMessage)
                    ->subject('ASMS - Buổi học kết thúc')
                 
                    ->view('emails.Attendance',['studentSection'=>$this->studentSection, 'sectionReport'=>$sectionReport]);
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
        $studentSection = $this->studentSection;    
        $section = $studentSection->section;

        return [
            'message' => "Buổi học ngày " . date('d/m/Y', strtotime($section->end_at)) . " của lớp {$section->course->code} đã kết thúc !"
        ];
       
    }
}


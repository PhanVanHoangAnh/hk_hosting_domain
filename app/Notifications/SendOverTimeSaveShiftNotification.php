<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Helpers\Pdf;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class SendOverTimeSaveShiftNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
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
                    // ->to(env('MAIL_TEST_ADDRESS'))
                    ->subject('ASMS - Thông báo quá giờ chốt ca')
                    // ->attachData($pdfContent, 'application.pdf', [
                    //     'mime' => 'application/pdf',
                    // ])
                    ->view('emails.OverTimeSaveShift',['course'=>$this->course]);
        } catch (\Exception $e) {
            Log::error('Email sending failed for order: ' . $this->order->id . ', Error: ' . $e->getMessage());
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
            'message' => "Lớp <strong>{$this->course->code}</strong> đã quá hạn chốt ca.",

        ];
    }
}




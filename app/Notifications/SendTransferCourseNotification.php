<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SendTransferCourseNotification extends Notification
{
    use Queueable;
  
    public $currentCourse;
    public $courseTransfer;
    public $orderItem;
    /**
     * Create a new notification instance.
     */
    public function __construct($currentCourse, $courseTransfer, $orderItem)
    {
        $this->currentCourse = $currentCourse;
        $this->courseTransfer = $courseTransfer;
        $this->orderItem = $orderItem;
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
                    ->subject('ASMS - Thông báo chuyển lớp')
                    // ->attachData($pdfContent, 'application.pdf', [
                    //     'mime' => 'application/pdf',
                    // ])
                    ->view('emails.TransferCourse',['currentCourse'=>$this->currentCourse, 'courseTransfer'=>$this->courseTransfer, 'orderItem'=>$this->orderItem]);
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
            'message' => "Đã chuyển học viên  <strong>{$this->orderItem->order->student->name }</strong> từ lớp <strong>{$this->currentCourse->code }</strong> sang lớp <strong>{$this->courseTransfer->code }</strong> thành công.",
        ];
    }
}

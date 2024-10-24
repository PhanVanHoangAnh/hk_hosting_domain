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

class SendOrderApprovedNottificationToUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
        $htmlContent = view('emails.pdfOrderApproval', [
            'order' => $this->order
        ])->render();
    
        $pdfContent = Pdf::exportPdf($htmlContent);
    
        try {
            return (new MailMessage)
                    ->subject('ASMS - Hợp đồng đã được duyệt')
                    ->attachData($pdfContent, 'application.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->view('emails.OrderApproved', [
                        'order' => $this->order
                    ]);
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
        return [
            //
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Pdf;

use App\Models\Order;
use App\Models\PaymentRecord;
use App\Models\PaymentAccount;

class NewPaymentRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public PaymentRecord $paymentRecord;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, PaymentRecord $paymentRecord)
    {
        $this->order = $order;
        $this->paymentRecord = $paymentRecord;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo từ hệ thống ASMS',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content  
    {
        return new Content(
            view: 'emails.NewPaymentRecordMail',
            with: [
                'order' => $this->order,
                'paymentRecord' => $this->paymentRecord,
            ]
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $exportPdf = true;
        $paymentAccounts = PaymentAccount::all();
        $htmlContent = view('accounting.payments.paymentPDF', [
            'paymentRecord' => $this->paymentRecord,
            'paymentAccounts' => $paymentAccounts,
            'order' => $this->order,
            'exportPdf' => $exportPdf
        ])->render();

        $pdfContent = Pdf::exportPdf($htmlContent);

        return $this->view('emails.NewPaymentRecordMail')
                    ->subject('Thông báo từ hệ thống ASMS')
                    ->with([
                        'order' => $this->order,
                        'paymentRecord' => $this->paymentRecord,
                    ])
                    ->attachData($pdfContent, 'order_approval.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}

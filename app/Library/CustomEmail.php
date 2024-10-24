<?php

namespace App\Library;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailMessage;

    public function __construct(MailMessage $mailMessage)
    {
        $this->mailMessage = $mailMessage;
    }

    public function build()
    {
        return $this->subject($this->mailMessage->subject)
            ->view($this->mailMessage->view, $this->mailMessage->viewData);
    }
}
<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Log;

class LogSendingMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSending $event)
    {
        $message = $event->message->toString();
        Log::channel('email')->info("Sending email:\n" . $message);
    }
}

<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ContactRequest;

class OrderCreatedUpdateLeadStatus
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $contactRequest = $order->contactRequest;

        if ($contactRequest) {
            $contactRequest->setLeadStatus(ContactRequest::LS_MAKING_CONSTRACT);
        }
    }
}

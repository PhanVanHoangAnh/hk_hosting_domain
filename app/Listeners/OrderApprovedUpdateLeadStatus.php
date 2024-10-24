<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ContactRequest;

class OrderApprovedUpdateLeadStatus
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
    public function handle(OrderApproved $event): void
    {
        $order = $event->order;
        $contactRequest = $order->contactRequest;

        if ($contactRequest) {
            $contactRequest->setLeadStatus(ContactRequest::LS_HAS_CONSTRACT);
            $contactRequest->setPreviousLeadStatus(ContactRequest::LS_HAS_CONSTRACT);
            $contactRequest->save();
        }
    }
}

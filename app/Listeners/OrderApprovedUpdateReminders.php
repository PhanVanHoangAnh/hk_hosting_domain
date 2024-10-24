<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ContactRequest;

class OrderApprovedUpdateReminders
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
        
        // update reminders
        $order->updateReminders();
    }
}

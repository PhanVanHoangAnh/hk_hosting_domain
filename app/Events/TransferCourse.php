<?php

namespace App\Events;

use App\Models\Course;
use App\Models\OrderItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Teacher;
use App\Models\User;

class TransferCourse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $currentCourse;
    public $courseTransfer;
    public $orderItem;
    public $user;

    /** 
     * Create a new event instance.
     */
    public function __construct( Course $currentCourse, Course $courseTransfer, OrderItem $orderItem, User $user )
    {
       
        $this->currentCourse = $currentCourse;
        $this->courseTransfer = $courseTransfer;
        $this->orderItem = $orderItem;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

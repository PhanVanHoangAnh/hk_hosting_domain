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

class AssigmentClass
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $orderItem;
    public $user;

    /** 
     * Create a new event instance.
     */
    public function __construct( User $user, Course $course, OrderItem $orderItem )
    {
       
        $this->course = $course;
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

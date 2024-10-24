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

class UpdateSchedule
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $user;

    /** 
     * Create a new event instance.
     */
    public function __construct( Course $course, User $user )
    {
       
        $this->course = $course;
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

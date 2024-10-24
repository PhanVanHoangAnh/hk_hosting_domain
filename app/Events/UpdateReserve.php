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

class UpdateReserve
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $currentCourseIds;
    public $reserveStartAt;
    public $user;
    public $orderItemIds;
    public $reserveEndAt;


    /** 
     * Create a new event instance.
     */
    public function __construct( $orderItemIds, $currentCourseIds, $reserveStartAt,$reserveEndAt, User $user )
    {
      
        $this->currentCourseIds = $currentCourseIds;
        $this->reserveStartAt = $reserveStartAt;
        $this->user = $user;
        $this->orderItemIds = $orderItemIds;
        $this->reserveEndAt = $reserveEndAt;
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

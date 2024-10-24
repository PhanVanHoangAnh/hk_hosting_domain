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

class UpdateReschedule
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sectionCurrent;
    public $section;
  
    


    /** 
     * Create a new event instance.
     */
    public function __construct( $sectionCurrent, $section )
    {
      
        $this->sectionCurrent = $sectionCurrent;
        $this->section = $section;
       
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

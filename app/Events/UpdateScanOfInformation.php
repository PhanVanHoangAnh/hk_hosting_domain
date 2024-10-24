<?php

namespace App\Events;

use App\Models\AbroadApplication;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateScanOfInformation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $abroadApplication;
    /**
     * Create a new event instance.
     */
    public function __construct(AbroadApplication $abroadApplication)
    {
        $this->abroadApplication = $abroadApplication;
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

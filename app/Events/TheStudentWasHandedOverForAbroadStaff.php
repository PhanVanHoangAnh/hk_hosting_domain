<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\AbroadApplication;
use App\Models\Account;

class TheStudentWasHandedOverForAbroadStaff
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $abroadApplication;
    public $staff;

    /**
     * Create a new event instance.
     */
    public function __construct(AbroadApplication $abroadApplication, Account $staff)
    {
        $this->abroadApplication = $abroadApplication;
        $this->staff = $staff;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name-' . $this->abroadApplication->id),
        ];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Mesin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kapasitas;
    public $cycle;

    public function __construct($kapasitas, $cycle)
    {
        $this->kapasitas = $kapasitas;
        $this->cycle = $cycle;
    }

    public function broadcastOn()
    {
        return new Channel('mesinPusher');
    }

    public function broadcastAs()
    {
        return 'mesin';
    }
}

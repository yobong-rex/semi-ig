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

public $id;

    public $kapasitas1;
    public $cycle1;

    public $kapasitas2;
    public $cycle2;

    public $kapasitas3;
    public $cycle3;

    public function __construct($id, $kapasitas1, $cycle1, $kapasitas2, $cycle2, $kapasitas3, $cycle3)
    {
        $this->id = $id;
        
        $this->kapasitas1 = $kapasitas1;
        $this->cycle1 = $cycle1;

        $this->kapasitas2 = $kapasitas2;
        $this->cycle2 = $cycle2;

        $this->kapasitas3 = $kapasitas3;
        $this->cycle3 = $cycle3;
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

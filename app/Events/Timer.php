<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Timer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $minute;
    public $second;
    public $status;
    
    public function __construct($minute, $second, $status)
    {
        $this->minute = $minute;
        $this->second = $second;
        $this->status = $status;
    }


    public function broadcastOn()
    {
        return new Channel('timePusher');
    }

    public function broadcastAs()
    {
        return 'time';
    }
}

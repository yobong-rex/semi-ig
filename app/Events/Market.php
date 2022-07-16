<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Market implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $market;
    public function __construct($market)
    {
        $this->market=$market;
    }

    public function broadcastOn()
    {
        return new Channel('stockChannel');
    }

    public function broadcastAs(){
        return 'market';
    }
}

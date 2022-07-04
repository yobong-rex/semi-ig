<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestPusher implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // field
    public $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    // kirim ke user tertentu
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }

    // kirim ke semua user
    public function broadcastOn()
    {
        return new Channel('testPusher');
    }

    public function broadcastAs(){
        return "public";
    }
}

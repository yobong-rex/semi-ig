<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Sesi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sesi;

    public function __construct($sesi)
    {
        $this->sesi=$sesi;
    }
    
    public function broadcastOn()
    {
        return new Channel('sesiPusher');
    }

    public function broadcastAs(){
        return 'sesi';
    }
}

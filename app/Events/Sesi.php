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

    public $id;
    public $sesi;
    public $waktu;

    public function __construct($id, $sesi, $waktu)
    {
        $this->id = $id;
        $this->sesi = $sesi;
        $this->waktu = $waktu;
    }

    public function broadcastOn()
    {
        return new Channel('sesiPusher');
    }

    public function broadcastAs()
    {
        return 'sesi';
    }
}

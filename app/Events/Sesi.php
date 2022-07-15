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
    public $mulai;

    public function __construct($id, $sesi, $waktu, $mulai)
    {
        $this->id = $id;
        $this->sesi = $sesi;
        $this->waktu = $waktu;
        // buat mengetahui game sedang berjalan, behenti, pause
        // start || pause || stop
        $this->mulai = $mulai;
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

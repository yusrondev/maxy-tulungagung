<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $isOwnMessage;
    public $name;

    public function __construct($message, $isOwnMessage, $name)
    {
        $this->message = $message;
        $this->isOwnMessage = $isOwnMessage;
        $this->name = $name;
    }

    public function broadcastOn()
    {
        return new Channel('public');
    }
}
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPrivateMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body;
    public $roomId;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($body, $roomId, $user)
    {
        //
        $this->body = $body;
        $this->roomId = $roomId;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.' . $this->roomId);
    }

    public function broadcastWith() 
    {
        return 
        [
            'body' => $this->body,
            'chat_id' => $this->roomId,
            'user' => $this->user,
        ];
    }
}

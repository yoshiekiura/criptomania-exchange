<?php

namespace App\Events\Exchange;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->notification = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return new PrivateChannel(channel_prefix() .'notifications.' . $this->notification->user_id);

    }

    public function broadcastWith()
    {
       return [
            'id' => $this->notification->id,
            'user_id' => $this->notification->user_id,
            'data' => $this->notification->data,
            'read_at' => $this->notification->read_at
            
        ];
    }
}

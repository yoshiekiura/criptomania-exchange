<?php

namespace App\Events\Exchange;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;


class BroadcastNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('notifications');
        // return new PrivateChannel(channel_prefix() .'notification.' . $this->notification->user_id);
        return new PrivateChannel(channel_prefix() .'notification.' . $this->notification->data . '.' . $this->notification->user_id);
        // return new PrivateChannel(channel_prefix() .'notification.' . $this->notification->user_id . '.' . $this->notification->data);


    }

     public function broadcastWhen()
    {
        return $this->notification->read_at == NULL;
    }

     /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'user_id' => $this->notification->user_id,
            'data' => $this->notification->data
        ];
    }
}

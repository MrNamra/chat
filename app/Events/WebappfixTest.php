<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebappfixTest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $channel;
    public $from;
    public $to_name;
    public $to;
    /**
     * Create a new event instance.
     */
    public function __construct($data, $channel, $from='', $to_name='', $to)
    {
        // $this->data = 'webappfix working...!!!';
        $this->data = $data;
        $this->channel = $channel;
        $this->from = $from;
        $this->to_name = $to_name;
        $this->to = $to;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new Channel('webapp'),
            new Channel($this->channel),
        ];
    }
}

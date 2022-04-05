<?php

namespace App\Events;

use App\Models\Lounge;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatWasSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(protected Lounge $lounge, public string $message, public $user = null)
    {

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('lounge.' . $this->lounge->id);
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user ? [
                'id' => $this->user?->id,
                'name' => $this->user?->name
            ] : null,
            'message' => $this->message,
        ];
    }
}

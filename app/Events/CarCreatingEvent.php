<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Lib\Models\Car;

class CarCreatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Car
     */
    public $car;
  
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Car $car)
    {
  
      $this->car = $car;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

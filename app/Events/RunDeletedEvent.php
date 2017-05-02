<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Lib\Models\Run;

class RunDeletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Run
     */
    public $run;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Run $run)
    {
        $this->run = $run;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('runs.'.$this->run->id);
    }
    public function broadcastAs(){
      return "deleted";
    }
    public function broadcastWith()
    {
      return [
        "run"=>json_decode((string)$this->run),
      ];
    }
}

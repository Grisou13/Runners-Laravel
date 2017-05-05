<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use Lib\Models\Run;

class RunCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  
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
        return new Channel('runs');
    }
    public function broadcastAs(){
        return "created";
    }
    public function broadcastWith()
    {
      //json_decode is a buit stupid, but can't do better for now
      \Log::debug("RUN CREATED");
      \Log::debug($this->run);
      \Log::debug($this->run->subscriptions);
      return [
        "run"=>$this->run,
        "waypoints"=>$this->run->waypoints()->get(),
        "subscriptions"=>$this->run->runners()->with(["car_type","user","car","car.car_type"])->get()
      ];
    }
}

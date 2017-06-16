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

class RunCreatingEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
  
  public $run;
  
  /**
   * Create a new event instance.
   *
   * @param Run $run
   */
  public function __construct(Run $run)
  {
    $this->run = $run->load(["waypoints","runners","runners.car","runners.car.car_type","runners.car_type","runners.user"]);
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
    return "creating";
  }
  public function broadcastWith()
  {
    //json_decode is a buit stupid, but can't do better for now
    
    return [
      "run"=>$this->run,
      "waypoints"=>$this->run->waypoints()->get(),
      "subscriptions"=>$this->run->runners()->with(["car_type","user","car","car.car_type"])->get()
    ];
  }
}

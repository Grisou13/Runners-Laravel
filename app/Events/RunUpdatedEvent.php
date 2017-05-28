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

class RunUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $run;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Run $run){
        $this->run = $run->load(["waypoints","runners","runners.car","runners.car.car_type","runners.car_type","runners.user"]);
        \Log::debug("CREA>TING EVENT RUN UPDATED");
        \Log::debug(print_r($this->run,true));
    }
    public function broadcastAs(){
        return "updated";
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
    // public function broadcastWith()
    // {
    //   return [
    //     "run"=>$this->run->load(["waypoints,runners,runners.car,runners.car.car_type,runners.car_type,runners.users"]),
    //     "waypoints"=>$this->run->waypoints,
    //     "subscriptions"=>$this->run->runners()->with(["car_type","user","car","car.car_type"])->get()
    //   ];
    // }
}

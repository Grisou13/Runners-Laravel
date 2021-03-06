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
use Lib\Models\RunSubscription;

class RunSubscriptionUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  
    /**
     * @var Run
     */
    public $run;
    /**
     * @var RunSubscription
     */
    public $run_subscription;
    
    /**
     * Create a new event instance.
     *
     * @param RunSubscription $run_subscription
     */
    public function __construct(RunSubscription $run_subscription)
    {
      $this->run_subscription = $run_subscription;
      $this->run = $run_subscription->run;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('runs.'.$this->run->id.'.subscriptions.'.$this->run_subscription->id);
    }
    public function broadcastAs(){
        return "updated";
    }
    public function broadcastWith()
    {
      return [
        "run"=>($this->run),
        "subscription"=>$this->run_subscription,
        "user"=>$this->run_subscription->user,
        "car"=>$this->run_subscription->car()->with(["car_type"])->get()->first(),
        "car_type"=>$this->run_subscription->car_type
        //"subscriptions"=>json_decode((string)$this->run->runners)
      ];
    }
}

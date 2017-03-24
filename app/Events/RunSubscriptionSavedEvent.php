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

class RunSubscriptionSavedEvent
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
        return new PrivateChannel('channel-name');
    }
}

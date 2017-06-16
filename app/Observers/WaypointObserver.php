<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.03.2017
 * Time: 10:02
 */

namespace App\Observers;
use App\Events\RunDeletingEvent;
use App\Events\RunSubscriptionSavingEvent;
use App\Events\WaypointCreatingEvent;
use App\Events\WaypointSavingEvent;
use App\Jobs\ProcessWaypoint;
use Lib\Models\RunSubscription;

class RunSubObserver
{
  public function subscribe($events)
  {
//    $events->listen(
//      'App\Events\WaypointSavingEvent',
//      [$this,'saving']
//    );
    $events->listen(
      'App\Events\WaypointSavedEvent',
      [$this,'saved']
    );
    $events->listen(
      'App\Events\WaypointCreatingEvent',
      [$this,'creating']
    );

    
  }
  public function creating(WaypointCreatingEvent $event){
    $self = $event->waypoint;
    if($self->geo != null)
      $self->latlng = $self->geo["geometry"]["location"];
  }
  public function saving(WaypointSavingEvent $event)
  {
    $point = $event->waypoint;
    if($point->geo == null)
      dispatch(new ProcessWaypoint($point));
  }
  public function saved(WaypointSavingEvent $event)
  {
    $point = $event->waypoint;
    if($point->geo == null)
      dispatch(new ProcessWaypoint($point));
  }
  

}
<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use App\Events\RunDeletedEvent;
use App\Events\RunDeletingEvent;
use App\Events\RunFinishedEvent;
use App\Events\RunSavedEvent;
use App\Events\RunSavingEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Lib\Concerns\SortablePivotTrait;
use App\Helpers\Status as StatusHelper;

class Run extends Model
{
    use SoftDeletes,ValidatingTrait,SortablePivotTrait, StatusConcern;
    public $rules = [
      "name"=>"required_if:artist,''",
    ];
    protected $fillable = [
        "name","planned_at","note","ended_at", "nb_passenger", "artist"
    ];
    protected $guarded = [
      "started_at"
    ];
    //protected $appends =["start_location","end_location"];
    protected $dates = [
        "created_at",
        "updated_at",
        "started_at",
        "ended_at",
        "planned_at"
    ];
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
      'saving' => RunSavingEvent::class,
      "saved" => RunSavedEvent::class,
      'deleting' => RunDeletingEvent::class,
      'deleted' => RunDeletedEvent::class
    ];

    public function waypoints(){
      //all fields selected in pivot table are prefixed with pivot_*
      return $this->sortableBelongsToMany(Waypoint::class,"order")->withPivot("order");
    }

    public function setArtistAttribute($value)
    {
      $this->attributes["name"]=$value;
      $this->attributes["artist"]=$value;
    }

    public function getEndLocationAttribute(){
      return $this->waypoints->last();
    }
    public function getStartLocationAttribute(){
      return $this->waypoints->first();
    }
    public function defaultRunName(){
      //try getting the name from the artist
      if(array_key_exists("artist",$this->attributes))
        return $this->attributes["artist"];
      //or maybe the starting point name
      return self::resolveGeoLocationName($this->waypoints->first()->geo);
    }
    public static function resolveGeoLocationName($geo){
      return $geo["address_components"][0]["short_name"];//force first element of result
    }
    public function users()
    {
        return $this->belongsToMany(User::class,"run_drivers")->using(RunDriver::class)->withPivot(["car_type_id","car_id"]);
    }
    public function cars()
    {
        return $this->belongsToMany(Car::class,"run_drivers")->using(RunDriver::class)->withPivot(["user_id","car_type_id"]);
    }
    public function car_types()
    {
        return $this->belongsToMany(CarType::class,"run_drivers")->using(RunDriver::class)->withPivot(["user_id","car_id"]);
    }
    public function subscriptions()
    {
        return $this->hasMany(RunSubscription::class);
    }
    //shorthand
    public function runners()
    {
      return $this->subscriptions();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
  
  
//  public function associateUser(User $user)
//  {
//    $user->status = "taken";
//    return $this->subscriptions()->firstOrNew(["run_id"=>$this->id,"user_id"=>$user->id])->user()->associate($user)->save();
//  }
//  public function associateCar(Car $car)
//  {
//    $car->status = "taken";
//    return $this->subscriptions()->firstOrNew(["run_id"=>$this->id,"car_id"=>$car->id])->car()->associate($car)->save();
//  }
//  public function associateCarType(CarType $car_type)
//  {
//    $this->status ="missing_car";
//    $this->save();
//    //$car->status = StatusHelper::getStatusKey($car_type,"taken");
//    return $this->subscriptions()->firstOrNew(["run_id"=>$this->id,"car_type_id"=>$car_type->id])->car_type()->associate($car_type)->save();
//  }
//  public function dissociateUser(User $user)
//  {
//
//  }
//  public function associateUserAndCar(User $user, Car $car)
//  {
//    if(!$this->exists)
//      return false;
//    //the number of subscriptions matches the number of full subscriptions for this run
//    if($this->subscriptions()->where("run_id",$this->id)->whereNotNull("user_id")->whereNotNull("car_id")->count() == $this->subscriptions()->count()) {
//      $this->status = "ready_to_go";
//      $this->save();
//    }
//    //$car->status = StatusHelper::getStatusKey($car_type,"taken");
//    $sub = $this->subscriptions()->firstOrNew(["run_id"=>$this->id,"car_id"=>$car->id, "user_id"=>$user->id]);
//    $sub->car()->associate($car);
//    $sub->user()->associate($user);
//    $sub->save();
//    return $sub;
//  }
//  public function associateUserAndCarType(User $user, CarType $car_type)
//  {
//    $this->status ="missing_car";
//    $this->save();
//    //$car->status = StatusHelper::getStatusKey($car_type,"taken");
//    $sub = $this->subscriptions()->firstOrNew(["run_id"=>$this->id,"car_type_id"=>$car_type->id, "user_id"=>$user->id]);
//    $sub->car_type()->associate($car_type);
//    $sub->user()->associate($user);
//    $sub->save();
//    return $sub;
//
//  }
//
//  public function dissociateCarType(CarType $car_type)
//  {
//  }
//
//  public function dissociateCar(Car $car)
//  {
//  }
}

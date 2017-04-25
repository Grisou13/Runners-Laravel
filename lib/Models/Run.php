<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use App\Events\RunDeletedEvent;
use App\Events\RunDeletingEvent;
use App\Events\RunFinishedEvent;
use App\Events\RunSavedEvent;
use App\Events\RunSavingEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
    protected $attributes = [
      "status"=>"free"
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
      return $this->attributes["name"]=$value; //instead set the run name prop
    }
    public function setTitleAttribute($val)
    {
      return $this->attributes["name"] = $val;
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
  /**
   * Should be readonly
   * @return
   */
    public function users()
    {
        return $this->belongsToMany(User::class,"run_drivers")->using(RunDriver::class)->withPivot(["car_type_id","car_id"]);
    }
  /**
   * Should be readonly
   * @return
   */
    public function cars()
    {
        return $this->belongsToMany(Car::class,"run_drivers")->using(RunDriver::class)->withPivot(["user_id","car_type_id"]);
    }
  
  /**
   * Should be readonly
   * @return
   */
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
  
  /**
   * Retrieves all the runs planned today
   * @param Builder $query
   * @return $this
   */
    public function scopeActif(Builder $query)
    {
      return $query->where( \DB::raw('DAY(planned_at)'), '>=', date('d'));
    }
}

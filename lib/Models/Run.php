<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use App\Events\RunCreatedEvent;
use App\Events\RunDeletedEvent;
use App\Events\RunDeletingEvent;
use App\Events\RunFinishedEvent;
use App\Events\RunSavedEvent;
use App\Events\RunSavingEvent;
use App\Events\RunUpdatedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Lib\Concerns\SortablePivotTrait;
use App\Helpers\Status as StatusHelper;

class Run extends Model
{
    use SoftDeletes,ValidatingTrait,SortablePivotTrait, StatusConcern, TransformableModel;

  
  public $rules = [
      "name"=>"required_if:artist,''",
    ];
    protected $fillable = [
        "name","planned_at","nb_passenger","note"
    ];
    protected $guarded = [
      "started_at","ended_at"
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
      'created'=>RunCreatedEvent::class,
      'deleting' => RunDeletingEvent::class,
      'deleted' => RunDeletedEvent::class,
      'updated' => RunUpdatedEvent::class
    ];
    public function getTimeAttribute()
    {
      return $this->planned_at->format("h:i");
    }
  public function getDateAttribute()
  {
    return $this->planned_at->format("d/m");
  }
    public function setArtistAttribute($value)
    {
      return $this->attributes["name"]=$value; //instead set the run name prop
    }
    public function setTitleAttribute($val)
    {
      return $this->attributes["name"] = $val;
    }

    public function waypoints(){
      //all fields selected in pivot table are prefixed with pivot_*
      return $this->sortableBelongsToMany(Waypoint::class,"order")->withPivot("order");
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
  
  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
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
   * @return Builder
   */
    public function scopeActif(Builder $query)
    {
      return $query->where( \DB::raw('DAY(planned_at)'), '>=', date('d'));
    }

  /**
   * @param $query
   * param $date string|Carbon
   * @return mixed
   *
   */
    public function scopeWhen($query, $date)
    {
      if(! ($date instanceof Carbon) )
        $date = new Carbon($date);
      return $query->where( \DB::raw('DATE(planned_at)'), '==', $date->toDateString());// + the run must be actif
    }
  /**
   * @param $query
   * param $dates array<string|Carbon>
   * @return mixed
   *
   */
  public function scopeWhenBetween($query, $dates)
  {
    list($d1,$d2) = $dates;
    if(is_string($d1))
      $d1 = new Carbon($d1);//d1 is the first day
    if(is_string($d2))
      $d2 = new Carbon($d2);//d2 is the last day
    
    return $query->where( \DB::raw('DATE(planned_at)'), '>=', $d1->toDateString())->where(\DB::raw('DATE(planned_at)'), '<=', $d2->toDateString());// + the run must be actif
  }
}

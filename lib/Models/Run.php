<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use App\Events\RunCreatedEvent;
use App\Events\RunCreatingEvent;
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
use App\Contracts\StatusableContract;

class Run extends Model implements StatusableContract
{
    use SoftDeletes,ValidatingTrait,SortablePivotTrait, StatusConcern, TransformableModel;

    public $casts = [
      "drafting"=>"boolean"
    ];
    public $rules =  [];
    public function rules()
    {
      if($this->drafting || !$this->exists)
        return [ //rules when drafting
          "name"=>"required|min:1",
          "nb_passenger"=>"sometimes|required|numeric|max:255",
        ];

      return [ //rules when publishing, or published
        "name"=>"required",
        "nb_passenger"=>"required|numeric|max:255",
        "planned_at"=>"required|date",
        "note"=>"sometimes|required|min:1",
        "waypoints.*.id"=>"required|exists:waypoints,id",
        "runners.*.car_type"=>"required_unless:runners.*.car,null",
//        "runners.*.car"=>"required_if:runners.*.car_type,null"
      ];
    }



    protected $fillable = [
        "name","planned_at","nb_passenger","note"
    ];
    protected $guarded = [
      "started_at","ended_at", "rules"
    ];
    protected $attributes = [
      "status"=>"free",
      "drafting"=>true
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
      "creating"=>RunCreatingEvent::class,
      'created'=>RunCreatedEvent::class,
      'deleting' => RunDeletingEvent::class,
      'deleted' => RunDeletedEvent::class,
      'updated' => RunUpdatedEvent::class
    ];

  public function publish()
  {
    $this->drafting = false;
    $this->save();
  }

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
   * Defines the cars,car_types,and drivers that are part of a run
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
    public function subscriptions()
    {
        return $this->hasMany(RunSubscription::class);
    }
  /**
   * Shorthand for subscriptions
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
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

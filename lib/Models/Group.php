<?php
/**
 * User: Eric.BOUSBAA
 */

namespace Lib\Models;

use App\Events\GroupSavedEvent;
use App\Helpers\Status;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "active",
        "color"
    ];

    protected $casts = [
        "active"=>"boolean"
    ];

//    protected $events = [
//        "updated" => GroupSavedEvent::class
//    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActifUser($query){
      return $query->whereHas("users",function($q){
//        $q->where("status",Status::getUserStatus("active_user"));
          $q->where("status", "free");
      });
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

//    public function schedules(){
//        return $this->belongsToMany(Schedule::class);
//    }
}

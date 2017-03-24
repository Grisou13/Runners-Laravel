<?php
/**
 * User: Eric.BOUSBAA
 */
namespace Lib\Models;

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
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function scopeActifUser($query){
      return $query->whereHas("users",function($q){
//        $q->where("status",Status::getUserStatus("active_user"));
          $q->whereNotNull("status");
      });
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }


//    public function schedules(){
//        return $this->belongsToMany(Schedule::class);
//    }
}

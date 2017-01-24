<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    protected $fillable = [
        "start_at","end_at","geo_from","geo_to","flight_num","note"
    ];
    protected $dates = [
        "created_at",
        "updated_at",
        "start_at",
        "end_at"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

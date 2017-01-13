<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    protected $fillable = [
        "start_date","end_date","start_site","arrival_site","flight_num","note"
    ];
    protected $dates = [
        "created_at",
        "updated_at",
        "start_date",
        "end_date"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

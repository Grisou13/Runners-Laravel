<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class Schedule extends Model
{
    use ValidatingTrait;
    protected $table = "schedule_groups";
    public $rules = [
        "start_time"=>"required|date",
        "end_time"=>"required|date|after:_start_time",

    ];
    public $timestamps = false;
    protected $fillable = ["start_time","end_time"];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

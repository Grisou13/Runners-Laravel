<?php

namespace Lib\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    public $fillable = ["value"];
/*
    public function getRouteKeyName()
    {


    }*/
}

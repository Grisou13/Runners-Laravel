<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    public $fillable = ["value"];
    public function users()
    {
      return $this->morphedByMany(User::class,"statusable");
    }
}
